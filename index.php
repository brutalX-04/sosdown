<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<title>xmod-sosdown</title>
	</head>
	<body>
		<nav>
			<div class="author">Xmod</div>
			<ul class="nav justify-content-center">
				<li class="">
					<a class="active" aria-current="page" href="#">Tiktok</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled">Youtube</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled">Facebook</a>
				</li>
			</ul>
		</nav>
		<div>
			<h4><center>Tiktok Downloader</center></h4>
			<form action="" method="POST" class="form">
				<input type="text" class="input" name="url" placeholder="Paste Link Here">
				<button type="submit" name="video" class="button">Download Video</button>
				<button type="submit" name="music" class="button">Download Musik</button>
			</form>
		</div>
		<?php
		include 'simple_html_dom.php';
		$folder = 'download/';
		$files = scandir($folder);

		foreach ($files as $file) {
		    if ($file != "." && $file != "..") {
		        $file_path = $folder . $file;
		        $file_timestamp = filemtime($file_path);
		        $current_timestamp = time();
		        $duration = 300;
		        if (($current_timestamp - $file_timestamp) > $duration) {
		            unlink($file_path); // Menghapus file
		        }
		    }
		}

		// TikTok API URL
		$url_api = 'https://api16-core.tiktokv.com/aweme/v1/feed/?aweme_id=7279199887407713542&openudid=vi8vz5c5aec5wllw&uuid=7661132520610792&_rticket=1694319262046&ts=1694319262&device_platform=android&channel=googleplay&ac=wifi';


		if(isset($_POST['music'])) {
			$html = file_get_html($_POST['url']);
		    $find = $html->find('link')[4]->href;
		    $cut = explode("/", $find);
		    $id_video = $cut[5];
			$url_api = "https://api16-core.tiktokv.com/aweme/v1/feed/?aweme_id=$id_video&openudid=vi8vz5c5aec5wllw&uuid=7661132520610792&_rticket=1694319262046&ts=1694319262&device_platform=android&channel=googleplay&ac=wifi";
		    $response_api = file_get_contents($url_api);

		    if ($response_api !== false) {
		        $data = json_decode($response_api);

		        if (isset($data->aweme_list) && is_array($data->aweme_list) && count($data->aweme_list) > 0) {
		            $url_music = $data->aweme_list[0]->music->play_url->url_list[0];

		            $nama_file = uniqid() . 'xmod.mp3';
		            $filePath = 'download/'. $nama_file;

		            $data = file_get_contents($url_music);

		            if ($data !== false) {
		                file_put_contents($filePath, $data);
		                echo "<div class='card'><audio controls src=\"$filePath\">Your browser does not support the audio element.</audio><div class='download'><a class='a' href='$filePath' download>Download</a></div></div>";

		            } else {
		                echo "<center>Gagal mengunduh Video. Pastikan URL valid.</center>";
		            }

		        } else {
		            echo "No videos found in the response.";
		        }
		    } else {
		        echo "Failed to retrieve data from the TikTok API.";
		    }
		}
		if(isset($_POST['video'])) {
			$html = file_get_html($_POST['url']);
		    $find = $html->find('link')[4]->href;
		    $cut = explode("/", $find);
		    $id_video = $cut[5];
			$url_api = "https://api16-core.tiktokv.com/aweme/v1/feed/?aweme_id=$id_video&openudid=vi8vz5c5aec5wllw&uuid=7661132520610792&_rticket=1694319262046&ts=1694319262&device_platform=android&channel=googleplay&ac=wifi";
		    $response_api = file_get_contents($url_api);
		    if ($response_api !== false) {
		        $data = json_decode($response_api);

		        if (isset($data->aweme_list) && is_array($data->aweme_list) && count($data->aweme_list) > 0) {
		            $url_video = $data->aweme_list[0]->video->play_addr->url_list[0];

		            $nama_file = uniqid() . 'xmod.mp4';
		            $filePath = 'download/'. $nama_file;

		            $data = file_get_contents($url_video);

		            if ($data !== false) {
		                file_put_contents($filePath, $data);
		                echo "<div class='card'><video class='card' controls><source src='$filePath' type='video/mp4'></video><div class='download'><a class='a' href='$filePath' download>Download</a></div></div>";

		            } else {
		                echo "<center>Gagal mengunduh Video. Pastikan URL valid.</center>";
		            }

		        } else {
		            echo "No videos found in the response.";
		        }
		    } else {
		        echo "Failed to retrieve data from the TikTok API.";
		    }
		}
		?>

	<footer>Copyright &copy; 2023 by Xmod-04</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>