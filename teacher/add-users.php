<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
    if(isset($_POST['submit'])) {
        $stuname=$_POST['stuname'];
        $stuemail=$_POST['stuemail'];
        $role=$_POST['role'];
        $connum=$_POST['connum'];
        $uname=$_POST['uname'];
        $password=$_POST['password'];
        $image=$_FILES["image"]["name"];
        $ret="select tendangnhap from nguoidung where tendangnhap=:uname";
        $query= $dbh -> prepare($ret);
        $query->bindParam(':uname',$uname,PDO::PARAM_STR);
        $query-> execute();
        $results = $query -> fetchAll(PDO::FETCH_OBJ);
        if($query -> rowCount() == 0) {
            $extension = substr($image,strlen($image)-4,strlen($image));
            $allowed_extensions = array(".jpg","jpeg",".png",".gif");
            if(!in_array($extension,$allowed_extensions)) {
                echo "<script>alert('Logo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            } else {
                $image=md5($image).time().$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],"../images/".$image);
                $sql="insert into nguoidung(tendangnhap,hoten,matkhau,email,sodienthoai,role,Image)values(:uname,:stuname,:password,:stuemail,:connum,:role,:image)";
                $query=$dbh->prepare($sql);
                $query->bindParam(':stuname',$stuname,PDO::PARAM_STR);
                $query->bindParam(':stuemail',$stuemail,PDO::PARAM_STR);
                $query->bindParam(':role',$role,PDO::PARAM_STR);
                $query->bindParam(':connum',$connum,PDO::PARAM_STR);
                $query->bindParam(':uname',$uname,PDO::PARAM_STR);
                $query->bindParam(':password',$password,PDO::PARAM_STR);
                $query->bindParam(':image',$image,PDO::PARAM_STR);
                $query->execute();
                $LastInsertId=$dbh->lastInsertId();
                if ($LastInsertId>0) {
                    echo '<script>alert("Student has been added.")</script>';
                    echo "<script>window.location.href ='manage-students.php'</script>";
                } else {
                    echo '<script>alert("Something Went Wrong. Please try again")</script>';
                    }
            }
        } else {
            echo "<script>alert('Username already exist. Please try again');</script>";
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <title>Thêm người dùng</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    
</head>
<body>
    <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/header.php');?>
    <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Thêm người dùng mới </h3>
                    </div>
                    <div class="row">
          
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Điền thông tin người dùng</h4>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      
                                    <div class="form-group">
                                        <label for="exampleInputName1">Họ tên</label>
                                        <input type="text" name="stuname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Email</label>
                                        <input type="text" name="stuemail" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Vai trò</label>
                                        <select name="role" value="" class="form-control" required='true'>
                                        <option value="">Vai trò</option>
                                        <option value="sinhvien">Sinh Viên</option>
                                        <option value="giaovien">Giáo Viên</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Ảnh đại diện</label>
                                        <input type="file" name="image" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Số điện thoại</label>
                                        <input type="text" name="connum" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                                    </div>
                      
                                    <h3>Thông tin đăng nhập</h3>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Tên đăng nhập</label>
                                        <input type="text" name="uname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Mật Khẩu</label>
                                        <input type="Password" name="password" value="" class="form-control" required='true'>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Thêm</button>
                     
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          <!-- content-wrapper ends -->
            </div>
        <!-- main-panel ends -->
        </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>