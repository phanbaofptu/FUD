<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    if(isset($_POST['submit'])){
        $description = $_POST['description'];
        $roomno = $_POST['rmno'];
        $area = $_POST['area'];
        $capacity = $_POST['capacity'];
        $id=$_GET['id'];
        $query="UPDATE rooms set description=?,area=?, capacity=?, where id=?";
        $stmt = $mysqli->prepare($query);
        $rc=$stmt->bind_param('ssii', $description,$area, $capacity,$id);
        $stmt->execute();
        echo"<script>alert('Room details has been updated');
        window.location.href='manage-rooms.php';
        </script>";
        }

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <?php include 'includes/navigation.php'?>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include 'includes/sidebar.php'?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Room Details</h4>
                        <div class="d-flex align-items-center">
                            <!-- <nav aria-label="breadcrumb">
                                
                            </nav> -->
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->

            <div class="container-fluid">

                <form method="POST">

                    <div class="row">


                    <?php	
                        $id=$_GET['id'];
						$ret="SELECT * from rooms where id=?";
                        $stmt= $mysqli->prepare($ret) ;
                     $stmt->bind_param('i',$id);
                     $stmt->execute() ;//ok
                     $res=$stmt->get_result();
                     //$cnt=1;
                       while($row=$res->fetch_object())
                      {
                          ?>


<div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Số phòng</h4>
                                    <div class="form-group">
                                        <input type="text" name="rmno" placeholder="Nhập số phòng" id="rmno" value="<?php echo $row->room_no;?>" 
                                            class="form-control" disabled>
                                    </div>
                                    <h4 class="card-title">Mô tả</h4>
                                    <div class="form-group">
                                        <input type="text" name="description" placeholder="Mô tả phòng" id="description" value="<?php echo $row->description;?>" 
                                            class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Khu vực</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" id="area" name="area" value="<?php echo $row->area;?>"  required="required">
                                            <option value="">Lựa chọn khu vực</option>
                                            <option value="Gamma">Gamma</option>
                                            <option value="Beta">Beta</option>
                                            <option value="Alpha">Alpha</option>
                                            <option value="Nhà võ">Nhà võ</option>
                                        </select>
                                    </div>
                                    <h4 class="card-title">Sức chứa</h4>
                                    <div class="form-group">
                                        <input type="number" name="capacity" value="<?php echo $row->capacity;?>"  placeholder="Số lượng chỗ ngồi"
                                            id="capacity" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Thông tin</h4>
                                    <?php
                                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                                    $date = getdate();
                                    echo "Thời gian cập nhật: " . date('H:i:s d-m-Y');
                                    ?>
                                    <?php
                                    $aid = $_SESSION['id'];
                                    $ret = "SELECT * from admin where id=?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $aid);
                                    $stmt->execute();
                                    $res = $stmt->get_result();

                                    while ($row = $res->fetch_object()) {
                                        ?>

                                        <?php echo "Người dùng: " . $row->username;
                                    } ?>
                                </div>
                            </div>

                        </div>

                        <?php } ?>

                    </div>
                

                        <div class="form-actions">
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                
                </form>


            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include '../includes/footer.php' ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>

</body>

</html>