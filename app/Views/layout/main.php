<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <?php echo $this->include('layout/footer'); ?>
    <?php echo $this->renderSection('content'); ?>
    <?php echo $this->include('layout/footer'); ?>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
</body>
</html>