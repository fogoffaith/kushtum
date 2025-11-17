<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-4">
      <div class="bg-dark p-4 rounded shadow">
        <form>
          <h2 class="h4 mb-3 text-white text-center">Sign In</h2>

          <div class="form-floating mb-3">
            <input type="text" class="form-control bg-dark" id="username" placeholder="Username">
            <label for="username">Username</label>
          </div>

          <div class="form-floating mb-3">
            <input type="password" class="form-control bg-dark" id="password" placeholder="Password">
            <label for="password">Password</label>
          </div>

          <div class="d-grid">
            <button class="btn btn-primary" type="submit">Sign in</button>
          </div>

          <div class="text-center mt-3">
            <small class="text-muted">
              <a href="#" class="text-decoration-none text-reset">Forgot password?</a> •
              <a href="#" class="text-decoration-none text-reset">Sign up</a>
            </small>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>