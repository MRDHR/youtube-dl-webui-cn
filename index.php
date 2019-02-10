<?php
	header("Content-type:text/html;charset=gb2312");
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;

			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$downloader = new Downloader($_POST['urls'], $audio_only);
			
			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
			}
		}
	}
?>
		<div class="container">
			<h1>����</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" class="form-horizontal" action="index.php" method="post">					
				<div class="form-group">
					<div class="col-md-10">
						<input class="form-control" id="url" name="urls" placeholder="��Ƶ����" type="text">
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="audio"> ֻ������Ƶ
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">����</button>
			</form>
			<br>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">��Ϣ</h3></div>
						<div class="panel-body">
							<p>ʣ��ռ� : <?php echo $file->free_space(); ?></b></p>
							<p>����Ŀ¼ : <?php echo $file->get_downloads_folder(); ?></p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">����</h3></div>
						<div class="panel-body">
							<p><b>������ι����ģ�</b></p>
							<p>ֻ���ڱ༭����ճ����Ƶ���ӣ�Ȼ���������ء�</p>
							<p><b>֧����Щ��վ��</b></p>
							<p><a href="http://rg3.github.io/youtube-dl/supportedsites.html">���� </a> ֧�ֵ���վ�б�</p>
							<p><b>����ڼ������������Ƶ��</b></p>
							<p>ת�� <a href="./list.php?type=v">��Ƶ�б�</a> -> ѡ��һ�� -> �Ҽ��������� -> "��Ŀ�����Ϊ..." </p>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
