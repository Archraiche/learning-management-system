<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800">Manage Students</h1>
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <?php include ('includes/admin_name.php'); ?>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="card-body">

                    <div class="table-responsive">

                    <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="manage-students-function.php" method = "POST"> 


                                                <div class="modal-body">
                                                
                                                        <input type="hidden" name= "add_ID" id ="add_ID">
                                                        <input type="hidden" name= "user_type" id ="user_type">

                                                        <div class="form-group">
                                                            <label for="#">Class - Section</label>
                                                            <select name="class_id" class="form-control" required>
                                                                        <option value="" disabled selected>Select Class</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Learner Reference Number (LRN)</label>
                                                            <input type="text" class="form-control" id="add_student_number" name="lrn" maxlength="13" minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">First Name</label>
                                                            <input type="text" class="form-control" name="firstname" id="add_First_Name" placeholder="Enter First Name" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Last Name</label>
                                                            <input type="text" class="form-control" name="lastname" id="add_Last_Name" placeholder="Enter Last Name" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="#">Email</label>
                                                            <input type="email" class="form-control" name="email" id="add_Email" placeholder="Enter email" required>
                                                        </div>

                                                        
                                                        <div class="form-group">
                                                            <label for="dob">Date of Birth</label>
                                                            <input type="text" class="form-control flatpickr" id="dob" name="dob" required placeholder="Enter Date of Birth">
                                                        </div>

                                                
                                                </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="add_student" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>  <!--end form -->
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    
                            <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_studentModal" style="margin-bottom: 20px; background-color:  #dfa106; border-color:  #dfa106;"><i class="fa fa-plus" aria-hidden="true"></i> Add Students</button>
            </td>
           

            <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <h1 class="h5 mb-0 text-gray-800">Student List</h1>
                    </div>
                        <?php
                            // Displaying data into tables with class_name
                            $query = "SELECT student.*, class.class_name FROM student
                                    LEFT JOIN class ON student.class_id = class.class_id";
                            $query_run = mysqli_query($conn, $query);
                        ?>

                            <table id = "dataTableID" class="table table-bordered table table-striped" width = "100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none;">Student ID</th>
                                        <th>Photo</th>
                                        <th>Learner Reference Number</th>
                                        <th style="display:none;">Firstname</th>
                                        <th style="display:none;">Lastname</th>
                                        <th>Name</th>
                                        <th>Section</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                            <!--<th colspan ="2">Action</th> Hindi pwedeng may colspan para sa dataTables--> 
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                        if(mysqli_num_rows($query_run) > 0) {
                                            while($row=mysqli_fetch_assoc($query_run))
                                            {
                                            
                                    ?>
                                        <tr>
                                            <td style="display:none;"><?php echo $row['student_id']; ?></td>
                                            <td> </td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><a href="profile.php?student_id=<?php echo $row['student_id']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></a></td>
                                            <td style="display:none;"><?php echo $row['firstname']; ?></td>
                                            <td style="display:none;"><?php echo $row['lastname']; ?></td>
                                            <td><?php echo $row['class_name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['dob']; ?></td>

                        <td>
                            <!--Edit Pop Up Modal -->
                            <div class="modal fade" id="edit_studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Student Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-students-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "edit_ID" id ="edit_ID">
                                               

                                                <div class="form-group">
                                                            <label for="#">Class - Section</label>
                                                            <select name="class_id" class="form-control" required>
                                                                        <option value="" disabled selected>Select Class</option>
                                                                        <?php
                                                                        $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                </div>
                                           
                                                <div class="form-group">
                                                            <label for="#">Learner Reference Number (LRN)</label>
                                                            <input type="text" class="form-control" id="edit_lrn" name="lrn" maxlength="13" minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">First Name</label>
                                                    <input type="text" class="form-control" name="firstname" id="edit_firstname" placeholder="Enter First Name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Last Name</label>
                                                    <input type="text" class="form-control" name="lastname" id="edit_lastname" placeholder="Enter Last Name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="#">Email</label>
                                                    <input type="email" class="form-control" name="email" id="edit_email" placeholder="Enter email" required>
                                                </div>

                                                        
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="text" class="form-control flatpickr" name="dob" id="edit_dob"required placeholder="Enter Date of Birth">
                                                </div>


                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="edit_student" class="btn btn-primary">Update</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                            <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#edit_studentModal" style="background-color:  #dfa106; border-color:  #dfa106;">Edit</button>
                        </td>

                        <td>

                        <!--Delete Pop Up Modal -->
                        <div class="modal fade" id="deletestudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <form action="manage-students-function.php" method = "POST"> 


                                        <div class="modal-body">
                                        
                                                <input type="hidden" name= "delete_ID" id ="delete_ID">

                                            <h5>Do you want to delete this data?</h5>

                
                                        
                                        </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="delete_student" class="btn btn-primary">Confirm</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>  

                 
                                <button type ="submit" name = "delete_btn" class = "btn btn-danger delete_btn" style="background-color:  #050c4b; border-color:  #050c4b;">Delete</button>
                   
                        </td>
                    </tr>
                    <?php
                            }
                        }
                        else 
                        {
                            echo "No Record Found";
                        }
                        ?>
                </tbody>
            </table>
    </div>
</div>



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



    


