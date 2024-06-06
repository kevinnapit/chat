<!-- user_list_view.php -->
<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="text-center">User List</h1>
    <div class="row">
        <?php foreach ($users as $user) : ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?= $user['profile_image'] ? base_url('uploads/image/' . $user['profile_image']) : 'default.png' ?>" class="card-img-top" alt="Profile Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $user['username'] ?></h5>
                        <a href="<?= base_url('chatcontroller/' . $user['id']) ?>" class="btn btn-primary">Chat</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
