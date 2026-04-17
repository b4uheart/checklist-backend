<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo html_escape($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login page for the Checklist application">

    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css">

    <style>
        body.authentication-bg {
            background:
                linear-gradient(135deg, rgba(10, 37, 64, 0.72), rgba(17, 103, 177, 0.48)),
                url('<?php echo base_url('assets/images/bg-auth.jpg'); ?>') center/cover no-repeat;
            min-height: 100vh;
        }

        .login-card {
            border: 0;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(15, 23, 42, 0.2);
        }

        .login-card .card-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        }

        .login-logo-badge {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0.08));
            color: #fff;
            font-size: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .form-control,
        .input-group-text {
            border-color: #d9e2ec;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card login-card">
                        <div class="card-header py-4 text-center">
                            <div class="login-logo-badge">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <h3 class="text-white mb-1"><?php echo html_escape($app_name); ?></h3>
                            <p class="text-white-50 mb-0">Project workspace login</p>
                        </div>

                        <div class="card-body p-4">
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark text-center pb-0 fw-bold">Sign In</h4>
                                <p class="text-muted mb-4"><?php echo html_escape($app_tagline); ?></p>
                            </div>

                            <form action="<?php echo site_url('login'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="text" id="emailaddress" name="email" placeholder="Enter your email" autocomplete="email">
                                </div>

                                <div class="mb-3">
                                    <a href="javascript:void(0);" class="text-muted float-end fs-12">Forgot your password?</a>
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember-me" name="remember" checked>
                                        <label class="form-check-label" for="remember-me">Remember me</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Need access? <a href="javascript:void(0);" class="text-white text-decoration-underline fw-semibold">Contact your administrator</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer footer-alt fw-medium">
        <span class="text-white-50">
            <script>
                document.write(new Date().getFullYear())
            </script> © <?php echo html_escape($app_name); ?>
        </span>
    </footer>

    <script src="<?php echo base_url('assets/js/app.min.js'); ?>"></script>
</body>

</html>
