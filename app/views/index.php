<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waiting List</title>
    <link href="./public/libs/bootstrap/bootstrap.min.css" rel="stylesheet">
</head>
<?php
$exceptionMessage = null;
$successMessage = null;

session_start();
if (isset($_SESSION['errorMessage'])) {
    $exceptionMessage = $_SESSION['errorMessage'];
}
unset($_SESSION['errorMessage']);

if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
}
unset($_SESSION['successMessage']);
?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body w-100">
                        <h4 class="card-title text-center">Waiting List</h4>
                        <hr />
                        <div id="messages">
                            <?php if ($exceptionMessage) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $exceptionMessage ?>
                            </div>
                            <?php } ?>
                            <?php if ($successMessage) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $successMessage ?>
                            </div>
                            <?php } ?>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Group ID</th>
                                    <th scope="col">Counter</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="text-center">
                            <a class="btn btn-primary btn-lg" id="joinBtn">Join To Waiting List</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="register" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Please enter username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Username</label>
                        <input name="username" id="modal-username-input" type="text" class="form-control" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./public/libs/bootstrap/bootstrap.bundle.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
    const joinBtn = document.getElementById('joinBtn');
    const modal = document.querySelector('#modal');
    joinBtn.addEventListener('click', function() {
        let username = getUsernameByCookie();
        if (username === null) {
            showModal();
        } else {
            $.post("join", {
                    "username": username
                },
                function(res) {
                    resJson = JSON.parse(res);
                    console.log(resJson);
                    if (resJson.status_code === 201) {
                        showMessage(resJson.message, 'success');
                        getList();
                    } else {
                        showMessage(resJson.message, 'danger');
                    }
                },
            )
        }
    });

    function getUsernameByCookie() {
        const cookieObj = new URLSearchParams(document.cookie.replaceAll("&", "%26").replaceAll("; ", "&"))
        return cookieObj.get("username")
    }

    function showModal() {
        new bootstrap.Modal(modal).show();
    }

    function hideModal() {
        new bootstrap.Modal(modal).hide();
    }

    function showMessage(message, type) {
        $('#messages').empty().append(`
            <div class="alert alert-${type}" role="alert">
                ${message}
            </div>
        `);
    }

    $(document).ready(function() {
        getList();
    });

    function getList() {
        $.get("list",
            function(res) {
                resJson = JSON.parse(res);
                console.log(resJson);
                if (resJson.status_code === 200) {
                    $('tbody').empty();
                    if (resJson.data.length > 0) {
                        resJson.data.forEach(function(data) {
                            $('tbody').append(`
                            <tr>
                                <td scope="row">${data.group_code}</td>
                                <td>${data.user_count} / 4</td>
                            </tr>
                        `)
                        });
                    } else {
                        $('tbody').append(`
                            <tr>
                                <td colspan="2" style="text-align:center">  Waiting List is empty. </td>
                            </tr>
                        `)
                    }

                } else {
                    showMessage("Unexpected error occured!", 'danger');
                }
            },
        )
    }
    setInterval(getList, 5000);
    
    </script>
</body>

</html>