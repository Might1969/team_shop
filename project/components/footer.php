<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Enhanced Footer</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    :root {
      --orange: #ff9900;
      --white: #ffffff;
      --black: #0f1111;
      --gray: #cccccc;
    }

    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f5f5;
    }

    .footer {
      background-color: var(--black);
      color: var(--white);
      padding: 5rem 2rem;
      font-size: 1.6rem;
      line-height: 1.8;
    }

    .footer a {
      color: var(--white);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer a:hover {
      color: var(--orange);
    }

    .footer .container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 3rem;
      align-items: flex-start;
    }

    .footer__socials {
      display: flex;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .footer__social-link {
      font-size: 2.6rem;
      opacity: 0.75;
      transition: all 0.3s ease;
    }

    .footer__social-link:hover {
      opacity: 1;
      color: var(--orange);
    }

    .footer__links {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    .footer__links a {
      font-size: 1.6rem;
    }

    /* 修正：footer__copyright 和 attribution 放在同一行 */
    .footer__copyright, .attribution {
      font-size: 1.4rem;
      color: #bbb;
      text-align: center;
      display: inline-block;
      padding: 1rem 0;
    }

    /* 使用 flexbox 将 copyright 和 attribution 放在同一行 */
    .footer__bottom {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 3rem;
      margin-top: 3rem;
    }

    @media (max-width: 768px) {
      .footer .container {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .footer__socials {
        justify-content: center;
      }

      .footer__links {
        align-items: center;
      }

      /* 在手机端布局时 copyright 和 attribution 会换行 */
      .footer__bottom {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <footer class="footer">
    <div class="container">
      <div class="footer__socials">
        <a href="https://github.com/" target="_blank" class="footer__social-link">
          <i class="ri-github-fill"></i>
        </a>
        <a href="https://web.wechat.com/" target="_blank" class="footer__social-link"> <!-- 修改了微信的跳转链接 -->
          <i class="ri-wechat-fill"></i>
        </a>
        <a href="https://www.linkedin.com/" target="_blank" class="footer__social-link">
          <i class="ri-linkedin-box-fill"></i>
        </a>
        <a href="https://x.com/" target="_blank" class="footer__social-link">
          <i class="ri-twitter-x-line"></i>
        </a>
      </div>

      <div class="footer__links col1">
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="#">Blog</a>
      </div>

      <div class="footer__links col2">
        <a href="#">Careers</a>
        <a href="#">Support</a>
        <a href="#">Privacy Policy</a>
      </div>
    </div>

    <!-- 使用 flexbox 对齐 copyright 和 attribution -->
    <div class="footer__bottom">
      <div class="footer__copyright">
        &copy; Team 06. All Rights Reserved.
      </div>
      <div class="attribution">
       CISC3003 Web Programming - 2025: Team 06 DC228265 Guan Zihan | DC228428 Zhang Jiaqi | DC228313 Ou Lingyi | DC229292 Chen Xingchen
      </div>
    </div>
  </footer>

</body>
</html>
