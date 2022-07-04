<?php
/**
 * @package        OpenCart
 * @author        Daniel Kerr
 * @copyright    Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 * @link        https://www.opencart.com
 */

/**
 * Image class
 */

namespace Opencart\System\Library;
class Image {
	private int $width;
	private int $height;
	private string $file;
	private object $image;	
	private string $bits;
	private string $mime;

	/**
	 * Constructor
	 *
	 * @param string $file
	 *
	 */
	public function __construct(string $file) {
		if (!extension_loaded('gd')) {
			exit('Error: PHP GD is not installed!');
		}

		if (is_file($file)) {
			$this->file = $file;

			$info = getimagesize($file);

			$this->width = $info[0];
			$this->height = $info[1];
			$this->bits = isset($info['bits']) ? $info['bits'] : '';
			$this->mime = isset($info['mime']) ? $info['mime'] : '';

			if ($this->mime == 'image/gif') {
				$this->image = imagecreatefromgif($file);
			} elseif ($this->mime == 'image/png') {
				$this->image = imagecreatefrompng($file);
			} elseif ($this->mime == 'image/jpeg') {
				$this->image = imagecreatefromjpeg($file);
			} elseif ($this->mime == 'image/webp') {
				$this->image = imagecreatefromwebp($file);
			}
		} else {
			throw new \Exception('Error: Could not load image ' . $file . '!');
		}
	}

	/**
	 *
	 *
	 * @return    string
	 */
	public function getFile(): string {
		return $this->file;
	}

	/**
	 *
	 *
	 * @return    array
	 */
	public function getImage(): string {
		return $this->image;
	}

	/**
	 *
	 *
	 * @return    int
	 */
	public function getWidth(): int {
		return $this->width;
	}

	/**
	 *
	 *
	 * @return    int
	 */
	public function getHeight(): int {
		return $this->height;
	}

	/**
	 *
	 *
	 * @return    string
	 */
	public function getBits(): string {
		return $this->bits;
	}

	/**
	 *
	 *
	 * @return    string
	 */
	public function getMime(): string {
		return $this->mime;
	}

	/**
	 *
	 *
	 * @param string $file
	 * @param int $quality
	 */
	public function save(string $file, int $quality = 90): void {
		$info = pathinfo($file);

		$extension = strtolower($info['extension']);

		if (is_object($this->image) || is_resource($this->image)) {
			if ($extension == 'jpeg' || $extension == 'jpg') {
				imagejpeg($this->image, $file, $quality);
			} elseif ($extension == 'png') {
				imagepng($this->image, $file);
			} elseif ($extension == 'gif') {
				imagegif($this->image, $file);
			} elseif ($extension == 'webp') {
				imagewebp($this->image, $file);
			}

			imagedestroy($this->image);
		}
	}

	/**
	 *
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $default
	 */
	public function resize(int $width = 0, int $height = 0, string $default = ''): void {
		if (!$this->width || !$this->height) {
			return;
		}

		$xpos = 0;
		$ypos = 0;
		$scale = 1;

		$scale_w = $width / $this->width;
		$scale_h = $height / $this->height;

		if ($default == 'w') {
			$scale = $scale_w;
		} elseif ($default == 'h') {
			$scale = $scale_h;
		} else {
			$scale = min($scale_w, $scale_h);
		}

		if ($scale == 1 && $scale_h == $scale_w && ($this->mime != 'image/png' || $this->mime != 'image/webp')) {
			return;
		}

		$new_width = (int)($this->width * $scale);
		$new_height = (int)($this->height * $scale);
		$xpos = (int)(($width - $new_width) / 2);
		$ypos = (int)(($height - $new_height) / 2);

		$image_old = $this->image;
		$this->image = imagecreatetruecolor($width, $height);

		if ($this->mime == 'image/png') {
			imagealphablending($this->image, false);
			imagesavealpha($this->image, true);

			$background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);

			imagecolortransparent($this->image, $background);

		} else if ($this->mime == 'image/webp') {
			imagealphablending($this->image, false);
			imagesavealpha($this->image, true);

			$background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);

			imagecolortransparent($this->image, $background);
		} else {
			$background = imagecolorallocate($this->image, 255, 255, 255);
		}

		imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

		imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width, $this->height);
		imagedestroy($image_old);

		$this->width = $width;
		$this->height = $height;
	}

	/**
	 *
	 *
	 * @param string $watermark
	 * @param string $position
	 */
	public function watermark(\Opencart\System\Library\Image $watermark, string $position = 'bottomright'): void {
		switch ($position) {
			case 'topleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = 0;
				break;
			case 'topcenter':
				$watermark_pos_x = (int)(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = 0;
				break;
			case 'topright':
				$watermark_pos_x = ($this->width - $watermark->getWidth());
				$watermark_pos_y = 0;
				break;
			case 'middleleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = (int)(($this->height - $watermark->getHeight()) / 2);
				break;
			case 'middlecenter':
				$watermark_pos_x = (int)(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = (int)(($this->height - $watermark->getHeight()) / 2);
				break;
			case 'middleright':
				$watermark_pos_x = ($this->width - $watermark->getWidth());
				$watermark_pos_y = (int)(($this->height - $watermark->getHeight()) / 2);
				break;
			case 'bottomleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = ($this->height - $watermark->getHeight());
				break;
			case 'bottomcenter':
				$watermark_pos_x = (int)(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = ($this->height - $watermark->getHeight());
				break;
			case 'bottomright':
				$watermark_pos_x = ($this->width - $watermark->getWidth());
				$watermark_pos_y = ($this->height - $watermark->getHeight());
				break;
		}

		imagealphablending($this->image, true);
		imagesavealpha($this->image, true);
		imagecopy($this->image, $watermark->getImage(), $watermark_pos_x, $watermark_pos_y, 0, 0, $watermark->getWidth(), $watermark->getHeight());

		imagedestroy($watermark->getImage());
	}

	/**
	 *
	 *
	 * @param int $top_x
	 * @param int $top_y
	 * @param int $bottom_x
	 * @param int $bottom_y
	 */
	public function crop(int $top_x, int $top_y, int $bottom_x, int $bottom_y): void {
		$image_old = $this->image;
		$this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);

		imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->width, $this->height);
		imagedestroy($image_old);

		$this->width = $bottom_x - $top_x;
		$this->height = $bottom_y - $top_y;
	}

	/**
	 *
	 *
	 * @param int $degree
	 * @param string $color
	 */
	public function rotate(int $degree, string $color = 'FFFFFF'): void {
		$rgb = $this->html2rgb($color);

		$this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));

		$this->width = imagesx($this->image);
		$this->height = imagesy($this->image);
	}

	/**
	 *
	 *
	 */
	private function filter(): void {
		$args = func_get_args();

		call_user_func_array('imagefilter', $args);
	}

	/**
	 *
	 *
	 * @param string $text
	 * @param int $x
	 * @param int $y
	 * @param int $size
	 * @param string $color
	 */
	private function text(string $text, int $x = 0, int $y = 0, int $size = 5, string $color = '000000'): void {
		$rgb = $this->html2rgb($color);

		imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
	}

	/**
	 *
	 *
	 * @param object $merge
	 * @param int $x
	 * @param int $y
	 * @param int $opacity
	 */
	private function merge(object $merge, int $x = 0, int $y = 0, int $opacity = 100): void {
		imagecopymerge($this->image, $merge->getImage(), $x, $y, 0, 0, $merge->getWidth(), $merge->getHeight(), $opacity);
	}

	/**
	 *
	 *
	 * @param string $color
	 *
	 * @return    array
	 */
	private function html2rgb(string $color): array {
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		if (strlen($color) == 6) {
			[$r, $g, $b] = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
		} elseif (strlen($color) == 3) {
			[$r, $g, $b] = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
		} else {
			return false;
		}

		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);

		return [$r, $g, $b];
	}
}