<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>
<?php
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
$firstname = $lastname = $useremail = $username =  $password = $confirm_password = $category ="";
$firstname_err = $lastname_err =$useremail_err = $username_err = $password_err = $confirm_password_err  = $category_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate useremail
    if (empty(trim($_POST["useremail"]))) {
        $useremail_err = "Please enter a useremail.";
    } elseif (!filter_var($_POST["useremail"], FILTER_VALIDATE_EMAIL)) {
        $useremail_err = "Invalid email format";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE useremail = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_useremail);

            // Set parameters
            $param_useremail = trim($_POST["useremail"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $useremail_err = "Este correo electrónico ya está en uso.";
                } else {
                    $useremail = trim($_POST["useremail"]);
                }
            } else {
                echo "¡Ups! Algo salió mal. Por favor, inténtelo de nuevo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);

        }
    }

    // Validate Firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Por favor, ingrese un nombre.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    // Validate Lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Por favor, ingrese un apellido.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, ingrese un nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, ingrese una contraseña.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor, introduzca una contraseña de confirmación.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "La contraseña no coincidió.";
        }
    }

    // Validate username
    if (empty(trim($_POST["category"]))) {
        $category_err = "Por favor, ingrese un nombre de usuario.";
    } else {
        $category = trim($_POST["category"]);
    }


    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($useremail_err) && empty($password_err) && empty($confirm_password_err)) {


        // Prepare an insert statement
        $sql = "INSERT INTO users ( useremail, username, password, token, name, lastname, category) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss",  $param_useremail,$param_username, $param_password, $param_token, $param_firstname, $param_lastname, $param_category);

            // Set parameters

            $param_useremail = $useremail;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_token = bin2hex(random_bytes(50)); // generate unique token
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_category = $category;



            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: apps-contacts-list.php");
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<head>

    <title>Listado de Usuario | Registro de Usuario</title>

    <?php include 'layouts/head.php'; ?>

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Registro de Usuario</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="apps-contacts-list.php">Usuarios</a></li>
                                <li class="breadcrumb-item active">Registro de Usuario</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Formulario de Registro de Usuario</h4>
                            <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Ingresar datos en los campos</h5>

                            <form class="needs-validation mt-4 pt-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row mb-4">
                                    <label for="firstname" class="col-sm-3 col-form-label">Nombre</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="firstname" placeholder="Ingrese su nombre" required name="firstname" value="<?php echo $firstnamename; ?>">
                                        <span class="text-danger"><?php echo $firstname_err; ?></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="lastname" class="col-sm-3 col-form-label">Apellido</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="lastname" placeholder="Ingrese su apellido" required name="lastname" value="<?php echo $lastname; ?>">
                                        <span class="text-danger"><?php echo $lastname_err; ?></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="username" class="col-sm-3 col-form-label">Nombre de Usuario</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="username" placeholder="Ingrese su nombre de usuario" required name="username" value="<?php echo $username; ?>">
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="useremail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-5">
                                        <input type="email" class="form-control" id="useremail" placeholder="Ingrese su email" required name="useremail" value="<?php echo $useremail; ?>">
                                        <span class="text-danger"><?php echo $useremail_err; ?></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="category" class="col-sm-3 col-form-label">Tipo de usuario</label>
                                    <div class="col-sm-5">
                                        <select id="category" class="form-select"  name="category">
                                            <?php try {
                                                $sql = 'SELECT id_Cat, cat_Nombre FROM user_category';
                                                foreach ($link->query($sql) as $rowc) {
                                                    if ($row['cat_Nombre']) {
                                                        $selected = 'selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option <?= $selected ?> value="<?= $rowc['id_Cat'] ?>"><?= $rowc['cat_Nombre'] ?></option>
                                                    <?php
                                                }
                                            } catch (PDOException  $e) {
                                                echo "Error: " . $e;
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="userpassword" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" id="userpassword" placeholder="Ingresar password" required name="password" value="<?php echo $password; ?>">
                                        <span class="text-danger"><?php echo $password_err; ?></span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirmar Password</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirmar password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                                        <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-sm-9">
                                        <div>
                                            <button class="btn btn-primary w-md" type="submit">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END layout-wrapper -->


<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/datatable-pages.init.js"></script>
<!-- validation init -->
<script src="assets/js/pages/validation.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

