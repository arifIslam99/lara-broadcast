<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
    <title>Live Chat</title>
</head>
<body>
<section style="background-color: #eee;">
  <div class="container py-5">

    <div class="row d-flex justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-4">
        
        <div class="card" id="chat1" style="border-radius: 15px;">
          <div
            class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <i class="fas fa-angle-left"></i>
            <p class="mb-0 fw-bold">Live chat</p>
            <i class="fas fa-times"></i>
          </div>
          <div class="card-body">
            <form action="#" method="POST" id="message_form">
            <div class="form-outline" id="messageShow">
                <input type="text" class="form-control" id="username" name="username" require />
                <label class="form-label">Type your name</label>
            </div>
            <!-- <div class="d-flex flex-row justify-content-start mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                alt="avatar 1" style="width: 45px; height: 100%;">
              <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
              <p class="small mb-0" id="messageShow"></p>
              </div>
            </div> -->

            <!-- <div class="d-flex flex-row justify-content-end mb-4">
              <div class="p-3 me-3 border" id="messageShow" style="border-radius: 15px; background-color: #fbfbfb;">
                
              </div>
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                alt="avatar 1" style="width: 45px; height: 100%;">
            </div> -->

            <div class="form-outline">
              <textarea class="form-control" id="message" name="message" rows="4"></textarea>
              <label class="form-label" for="message">Type your message</label>
            </div>
            <button type="button" class="btn btn-primary" id="send_message">Send</button>
            </form>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>
