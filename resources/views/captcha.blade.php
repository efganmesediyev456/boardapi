<!doctype html>
<html lang = "en">
<head>
    <!-- Required meta tags -->
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel = "stylesheet"
            integrity = "sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
            crossorigin = "anonymous">
    <title>Hello, world!</title>
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->


<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <form action = "/captcha" method="POST">
                @csrf
                <div class="form-group">
                    <label for = "">Email</label>
                    <input value="{{old("email")}}" type = "text" class="form-control @error('email') border-danger  @enderror " name="email">
                    @error("email") <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for = "">Password</label>
                    <input value="{{old("password")}}" type = "text" class="form-control @error('password') border-danger @enderror" name="password">
                    @error("password") <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <label for = "">Captcha</label>
                    <span id="captcha_mg">{!! captcha_img() !!}</span> <a href="#" id="refresh" class="btn btn-success">Refresh</a> </p>
                    <input value="{{old("captcha")}}" type = "text" class="form-control @error('captcha') border-danger @enderror" name="captcha">
                    @error("captcha") <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="form-group">
                    <input type = "submit" class="btn btn-primary">
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $("#refresh").on("click",function () {
        $.ajax({
            url:"/captcha/refresh",
            type:"POST",
            data:{"_token":"{{csrf_token()}}"},
            success:function (e) {

                $("#captcha_mg").html(e.captcha)
            }
        })
    })
</script>
<script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity = "sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin = "anonymous"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>