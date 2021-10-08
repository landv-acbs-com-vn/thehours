<?php
//delete post
if (isset($_GET['delete_id'])) {
    global $conn;
    $id=$_GET['delete_id'];
    $sql = "DELETE FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: ' . BASE_URL . 'manage-posts/');
        exit(0);
    }
}

//add post
if (isset($_POST['add-post'])) {
    global $conn;
    $errors = validatePost($_POST);

    // không có lỗi thì sẽ tải ảnh lên
    if (count($errors) == 0) {
        if (!empty($_FILES['image_path']['name'])) {
            $image_name = time() . '_' . $_FILES['image_path']['name'];
            $destination = ROOT_PATH. "/uploads/images/" . $image_name;

            $result = move_uploaded_file($_FILES['image_path']['tmp_name'], $destination);

            if ($result) {
                $_POST['image_path'] = "./uploads/images/" . $image_name;//update path mới
            } else {
                array_push($errors, "Không thể tải ảnh lên máy chủ");
            }
        } else {
            array_push($errors, "Cần phải thêm ảnh cover cho bài viết");
        }
    }

    //no errors => add to db
    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['user_id'];
        $_POST['IsPublished'] = 1;
        $_POST['content'] = htmlentities($_POST['content']);
        $_POST['slug'] = $post_model->createSlug($_POST['title']);
        $_POST['views']=0;
        
        $sql = "INSERT INTO posts (`user_id`, `topic_id`, `title`, `content`, `slug`, `image_path`, `IsPublished`, `views`) 
        VALUES ('".$_POST['user_id']."', '".$_POST['topic_id']."', '".$_POST['title']."', '".$_POST['content']."', '".$_POST['slug']."', '".$_POST['image_path']."', '".$_POST['IsPublished']."', '".$_POST['views']. "')";
        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("location: " . BASE_URL . "manage-posts/");
            exit(0);
        }
    }
}

//update post
if (isset($_POST['update-post'])) {
    // adminOnly();
    global $conn;
    $errors = validatePost($_POST);
    $hasPicture = false;

    // không có lỗi thì sẽ tải ảnh lên
    if (count($errors) == 0) {
        if (!empty($_FILES['image_path']['name'])) {
            $image_name = time() . '_' . $_FILES['image_path']['name'];
            $destination = ROOT_PATH ."/uploads/images/" . $image_name;

            $result = move_uploaded_file($_FILES['image_path']['tmp_name'], $destination);

            if ($result) {
                $_POST['image_path'] = "./uploads/images/" . $image_name;//update path mới
                $hasPicture = true;
            } else {
                array_push($errors, "Không thể tải ảnh lên máy chủ");
            }
        }
    }

    if (count($errors) == 0) {
        unset($_POST['update-post']);
        $_POST['user_id'] = $_SESSION['user_id'];
        $_POST['IsPublished'] = 1;
        $_POST['content'] = htmlentities($_POST['content']);
        $_POST['slug'] = $post_model ->createSlug($_POST['title']);

        if ($hasPicture) {
            $sql = "UPDATE posts SET `topic_id`"."='".$_POST['topic_id']."', `title`"."='".$_POST['title']."', `content`"."='".$_POST['content']."', `slug`"."='".$_POST['slug']."', `image_path`"."='".$_POST['image_path']."', `IsPublished`"."='".$_POST['IsPublished']."'  WHERE id='".$_POST['id']. "'";
        } else {
            $sql = "UPDATE posts SET `topic_id`"."='".$_POST['topic_id']."', `title`"."='".$_POST['title']."', `content`"."='".$_POST['content']."', `slug`"."='".$_POST['slug']."', `IsPublished`"."='".$_POST['IsPublished']."'  WHERE id='".$_POST['id']. "'";
        }
        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("location: " . BASE_URL . "manage-posts/");
            exit(0);
        }
    }
}

// published / unpublished
if (isset($_GET['PublishToggleId'])) {
    global $conn;
    $sql = "UPDATE posts SET `IsPublished`"."='".$_GET['IsPublished']."'  WHERE id='".$_GET['PublishToggleId']. "'";
    unset($_GET['IsPublished'], $_GET['PublishToggleId']);
    $result = mysqli_query($conn, $sql);
    echo $sql;
    if ($result) {
        header("location: " . BASE_URL . "manage-posts/");
        exit(0);
    }
}
