<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<style>
  @font-face {
  font-family: 'HKGroteskLegacy';
  src: url('{{ asset('fonts/HKGrotesk-RegularLegacy.otf') }}');
  }

  @font-face {
    font-family: 'HKGrostekBold';
    src: url('{{ asset('fonts/HKGrotesk-Bold.otf') }} ');
  }

  body {
    padding: 0;
    margin: 0;
    font-family: 'HKGroteskLegacy', serif;
  }

  .wrap {
  }

  .container {
    width: 780px;
    margin: 0 auto;
  }

  /* ---------------HEADER--------------- */

  header {
    padding: 3em 0;
  }

  .wrap-logo {
    display: flex;
    margin: 0 240px;
    text-align: center;
    align-items: center;
  }

  .logo {
    padding-right: 10px;
  }

  h1 {
    color: #284260;
  }


  /* ---------------SECTION--------------- */
  section {
    width: 720px;
    margin: 0 auto;
    padding-bottom: 2em;
  }

  .card {
    text-align: center;
    align-items: center;
    box-shadow: 0 2px 10px 5px #e9eef5;
  }

  .wrap-avatar {
    padding-top: 4em;
  }

  .avatar {
    border-radius: 50%;
    background: #E1EBF8;
    height: 80px;
    width: 80px;
    text-align: center;
    align-items: center;
  }

  .wrap-title {
    padding-bottom: 4em;
  }

  .wrap-title p {
    padding-bottom: 2em;
    width: 330px;
    margin: 0 auto;
    font-size: 14px;
  }

  .btn {
    background: #4CB050;
    border: none;
    padding: 10px 40px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    color: #fff;
    box-shadow: 0 2px 8px #e1ebf8;
    transition: 0.7s;
  }

  .btn:hover {
    background: #44a048;
  }

  /* ---------------FOOTER--------------- */
  footer {
    width: 330px;
    margin: 0 auto;
    text-align: center;
  }

  .sosmed img{
    width: 35px;
    height: 35px;
    padding: 1em;
  }

  .about p {
    font-size: 12px;
    line-height: 2em;
  }

  .about p a {
    color: #80E37E;
  }
</style>
<body>
  <div class="Wrap">
    <div class="container">
      <header>
        <div class="wrap-logo">
          <img src="{{ asset('images/bs_kemnaker.svg') }}" class="logo">
          <h1>Klikkk ABG</h1>
        </div>
      </header>

      <section>
        <div class="card">
          <div class="wrap-avatar">
            <img src="{{ asset('images/ic_orang.svg') }}" class="avatar">
          </div>

          <div class="wrap-title">
            <h3>{{ $user->nama_lengkap }},</h3>

            <p>Terimakasih sudah mendaftar di klikk abg. Silahkan klik tombol konfirmasi di bawah ini untuk menyelesaikan proses
              pendaftaran Anda.
            </p>

            <button type="button" class="btn">Konfirmasi</button>
          </div>

        </div>
      </section>

      <footer>
        <div class="sosmed">
          <img src="{{ asset('images/ic_fb.svg')}}">
          <img src="{{ asset('images/ic_ig.svg')}}" class="ig">
          <img src="{{ asset('images/ic_twitter.svg')}}">
        </div>

        <div class="about">
          <p>
            Tentang, Layanan, bbpk3 Makassar, <br> Ketentuan, Pertanyaan <br>
            Kontak : <a href="">@klikkkabg.id</a>
          </p>
        </div>
      </footer>
    </div>
  </div>
</body>
</html>