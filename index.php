<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <link rel="stylesheet" href="/style/login.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>

<body>
  <div class="container-fluid bg-danger position-fixed top-0 end-0 bottom-0 start-0 d-flex justify-content-center d-flex align-items-center">
    <div class="row">
      <div class="col p-0">
        <div class="container bg-white shadow p-3 mb-5 bg-body rounded" style="width: 650px; height: 650px; padding: 50px 0">
          <div class="container" style="padding: 50px">
            <div class="row d-flex justify-content-center">
              <div class="container d-flex justify-content-center">
                <img src="image/logo.png" style="width: 150px; height: 150px" />
              </div>
            </div>
            <div class="row d-flex justify-content-center text-success fs-1 fw-bold">
              Valorian Pizza
            </div>
            <div class="row">
              <form action="config/login.php" method="post">
                <?php if (isset($_SESSION['error'])) { ?>
                  <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                  </div>
                <?php } ?>

                <?php if (isset($_SESSION['alert'])) { ?>
                  <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['alert'];
                    unset($_SESSION['alert']);
                    ?>
                  </div>
                <?php } ?>

                <div class="mb-3">
                  <label for="username" class="form-label">ชื่อผู้ใช้</label>
                  <input type="text" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded" id="username" name="username" />
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">รหัสผ่าน</label>
                  <input type="password" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded" id="password" name="password" />
                </div>

                <div class="d-flex justify-content-center" style="margin-top: 50px">
                  <button type="submit" class="btn btn-warning text-white rounded-pill" style="padding: 15px 40px">
                    เข้าสู่ระบบ
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col p-0">
        <div class="container shadow" style="width: 650px; height: 650px; padding: 0;">
          <img class="rounded-3" src="https://therecipecritic.com/wp-content/uploads/2019/05/besthomemadepizzahero.jpg" width="650px" height="650px" style="object-fit: cover;">
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.js" integrity="sha512-docBEeq28CCaXCXN7cINkyQs0pRszdQsVBFWUd+pLNlEk3LDlSDDtN7i1H+nTB8tshJPQHS0yu0GW9YGFd/CRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</body>

</html>