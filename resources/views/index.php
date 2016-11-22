<!DOCTYPE html>
<html ng-app="app">
  <head>
    <meta charset="utf-8">
    <title>Custom Page</title>

    <!-- main library files -->
    <script src="scripts/node_modules/angular/angular.min.js"></script>
    <script src="scripts/js/vendor/angular-route.js"></script>
    <script src="scripts/js/vendor/angular-messages.js"></script>
    <script src="scripts/js/vendor/jquery.js"></script>
    <script src="scripts/js/vendor/boostrap.min.js"></script>
    <script src="scripts/js/vendor/ui-bootstrap-tpls-1.3.2.min.js"></script>
    <script src="scripts/js/vendor/jQuery-viewport-checker.min.js"></script>
    <script src="scripts/node_modules/satellizer/dist/satellizer.min.js"></script>
    <script src="scripts/node_modules/angular-ui-router/release/angular-ui-router.min.js"></script>
    <!-- main style files -->
    <link rel="stylesheet" href="scripts/style/css/bootstrap-theme.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="scripts/style/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="scripts/style/css/main.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="scripts/style/css/animate.css" media="screen" title="no title" charset="utf-8">

    <!-- main Angular app file -->
    <script src="scripts/app.js"></script>

    <!-- controllers -->
    <script src="scripts/email/controllers/emailController.js"></script>
    <script src="scripts/email/controllers/registerController.js"></script>
    <script src="scripts/email/controllers/personalEmailController.js"></script>
    <script src="scripts/email/controllers/loginController.js"></script>
    <script src="scripts/email/controllers/sendMessage.js"></script>


    <!-- directives -->
    <script src="scripts/email/directives/navbar.js"></script>
    <script src="scripts/email/directives/sidebar.js"></script>
    <script src="scripts/email/directives/mainContent.js"></script>


    <!-- services -->
    <script src="scripts/email/services/emailService.js"></script>

    <!-- factories -->
    <script src="scripts/email/factories/sharedData.js"></script>

    <!-- Angular route file -->
  </head>
  <body>
    <div ui-view class="content"></div>
	</body>
</html>
