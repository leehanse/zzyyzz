<?php
	session_start();
	//YOU CAN HANDLE SESSIONING HERE....
	
	if (isset($_REQUEST['clear'])) {
		if (isset($_SESSION['w2p_projects'])) {		
			if (isset($_SESSION['w2p_projects'][$_REQUEST['productid']])) {
				unset($_SESSION['w2p_projects'][$_REQUEST['productid']]);
			}
		}
		exit();
	}
	
	if (!isset($_SESSION['w2p_projects'])) {
		$_SESSION['w2p_projects'] = array();
		$_SESSION['w2p_projects'][$_POST['productid']] = array();
	} else if (!isset($_SESSION['w2p_projects'][$_POST['productid']])) {
		$_SESSION['w2p_projects'][$_POST['productid']] = array();
	}

	$previews = explode(',', $_POST['previews']);
	$renderings = explode(',', $_POST['renderings']);
		
	$newPreviews = array();
	$newRenderings = array();
	
	if ($_POST['previews'] != '') {
		for ($i = 0; $i < count($previews); $i++) {
			if ($previews[$i] !== '') {
				$dest = explode('/', $previews[$i]);
				$dest = array_pop($dest);
				array_push($newPreviews, $dest);
				$dest = '../image/data/previews/' . $dest;
				copy($previews[$i], $dest);
			}
		}
	}
	
	if ($_POST['renderings'] != '') {	
		for ($i = 0; $i < count($renderings); $i++) {
			if ($renderings[$i] !== '') {
				$dest = explode('/', $renderings[$i]);
				$dest = array_pop($dest);
				array_push($newRenderings, $dest);
				$dest = '../image/data/renderings/' . $dest;
				copy($renderings[$i], $dest);
			}
		}
	}
	
	$newPreviews = implode(',', $newPreviews);
	$newRenderings = implode(',', $newRenderings);
	
	$_SESSION['w2p_projects'][$_POST['productid']]['previews'] = $newPreviews;
	$_SESSION['w2p_projects'][$_POST['productid']]['renderings'] = $newRenderings;
	$_SESSION['w2p_projects'][$_POST['productid']]['projectid'] = $_POST['projectid'];
	$_SESSION['w2p_projects'][$_POST['productid']]['uid'] = $_POST['uid'];
	
?>