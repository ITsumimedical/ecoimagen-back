<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Ahmed Mohamed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My new Project</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');

    * {
        font-family: 'Roboto', sans-serif;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        font-size: 65.5%;
    }

    .header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #fff;
        width: 100vw;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 3rem;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        box-shadow: 2px 2px 15px #ccc;

    }

    .header .nav {
        display: flex;
        align-items: center;
    }

    .header .nav ul {
        list-style: none;
    }

    .header .nav ul li {
        display: inline-block;
        padding: 0 1rem;
    }

    .header .nav li a {
        text-decoration: none;
        font-size: 1.25rem;
        color: #333;
        font-weight: 700;
    }

    .header .nav .button {
        margin-left: 2rem;
    }

    .header .nav .button a {
        text-decoration: none;
        font-size: 1.25rem;
        color: #fff;
        font-weight: 700;
    }

    .header .nav ul li a:hover {
        color: #0099ff;
        transition: .25s;
    }

    .header .nav .button button {
        padding: .8rem 1.6rem;
        border: none;
        border-radius: 3rem;
        background: rgb(72, 73, 255);
        background: linear-gradient(90deg, rgba(72, 73, 255, 1) 0%, rgba(57, 247, 255, 1) 100%);
    }

    .header .nav .button button:hover {
        background: #fff;
        border: 2px solid #0099ff;
        transition: .75s;
        padding: .6rem 1.4rem;
    }

    .header .nav button:hover a {
        color: #333;
        transition: .75s;
    }

    @media (max-width: 767px) {
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
        }
    }

    .home {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 100vw;
        padding: 2rem 3rem;
    }

    .home .content {
        width: 45%;
        margin: 2rem
    }

    .home .content h1 {
        font-size: 3rem;
        margin-bottom: 2rem;
    }

    .home .content p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        color: #555;
    }

    .home .content .buttons button {
        padding: .6rem 1.6rem;
        border: 2px solid #0099ff;
        border-radius: 3rem;
        background: #0099ff;
        margin-right: 2rem;
    }

    .home .content button a {
        text-decoration: none;
        font-size: 1.25rem;
        color: #fff;
        font-weight: 700;
    }

    .home .content button:hover {
        background: #fff;
        border: 2px solid #0099ff;
        transition: .75s;
    }

    .home .content button:hover a {
        color: #0099ff;
        transition: .75s;
    }

    .home .img-right {
        width: 50%;
    }

    .home .img-right img {
        width: 100%;
    }

    @media (max-width: 767px) {
        .home {
            display: flex;
            justify-content: space-evenly;
            flex-direction: column;
            align-items: center;
        }

        .home .content {
            width: 100%
        }

        .home .img-right {
            width: 100%
        }
    }

    .services {
        width: 100vw;
        padding: 2rem 3rem;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        overflow: hidden;
    }

    .services .header-page {
        width: 60%;
        text-align: center;
        margin-bottom: 4rem;
    }

    .services .header-page h1 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .services .header-page h1 span {
        color: #0099ff;
    }

    .services .header-page p {
        font-size: 1.25rem;
        color: #555;
    }

    .services .container-box {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .services .box {
        width: 30rem;
        margin: 1rem;
        box-shadow: 2px 2px 10px #eee,
            -2px -2px 10px #eee;
        border-radius: 1rem;
        border-top-right-radius: 5rem;
        padding: 2rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .services .box:hover {
        background: #0099ff;
        transition: 1s;
    }

    .services .box:hover i,
    .services .box:hover h2,
    .services .box:hover p,
    .services .box:hover button a {
        color: #fff;
    }

    .services .container-box i {
        font-size: 3rem;
        margin-bottom: 2rem;
        color: #0099ff;
    }

    .services .container-box h2 {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    .services .container-box p {
        font-size: 1.25rem;
        text-align: center;
        margin-bottom: 1rem;
        color: #555;
    }

    .services .container-box button {
        border: 2px solid #fff;
        padding: .6rem 1.6rem;
        border-radius: 3rem;
    }

    .services .container-box button:hover {
        border: 2px solid #0099ff;
    }

    .services .container-box button a {
        text-decoration: none;
        font-weight: 400;
        font-size: 1.35rem;
        text-align: center;
        color: #0099ff;
    }

    .about {
        width: 100vw;
        padding: 2rem 3rem;
        overflow: hidden;
        position: relative;
    }

    .about .header-page {
        width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 4rem;
    }

    .about .header-page h1 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .about .header-page h1 span {
        color: #0099ff;
    }

    .about .header-page p {
        font-size: 1.25rem;
        text-align: center;
        width: 60%;
        color: #555;
    }

    .about .content {
        width: 50%;
        height: 50rem;
        margin-bottom: 4rem;
    }

    .about .content .cont-box {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .about .content .cont-box .box {
        width: 50rem;
        margin: 1rem;
        box-shadow: 2px 2px 10px #eee,
            -2px -2px 10px #eee;
        border-radius: 4rem;
        padding: 2rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .about .content .cont-box .box h3 {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .about .content .box:hover h3 {
        color: #0099ff;
        transition: .25s
    }

    .about .content .cont-box .box p {
        font-size: 1.25rem;
        text-align: center;
        color: #555;
    }

    .about .pbp {
        width: 100%;
        margin-bottom: 4rem;
        display: flex;
        justify-content: center;
        flex-direction: column;
        flex-wrap: wrap;
        align-items: center;
        text-align: center;
        color: #555;
    }

    .about .pbp button {
        margin: 1rem;
        padding: .8rem 1.6rem;
        border: none;
        border-radius: 3rem;
        background: rgb(72, 73, 255);
        background: linear-gradient(90deg, rgba(72, 73, 255, 1) 0%, rgba(57, 247, 255, 1) 100%);
    }

    .about .pbp button a {
        text-decoration: none;
        font-size: 1.25rem;
        color: #fff;
        font-weight: 700;
    }

    .about .pbp button:hover {
        background: #fff;
        border: 2px solid #0099ff;
        transition: .75s;
        padding: .6rem 1.4rem;
    }

    .about .pbp button:hover a {
        color: #333;
        transition: .75s;
    }

    .about .img {
        width: 40%;
        position: absolute;
        top: 14rem;
        right: 2rem;
    }

    .about .img img {
        width: 100%;
    }

    @media (max-width: 767px) {
        .about {
            display: flex;
            justify-content: space-evenly;
            flex-direction: column;
            align-items: center;
        }

        .about .img {
            width: 100%;
            position: static;
        }

        .about .content {
            width: 120%;
        }

        .about .content .cont-box .box {
            width: 80%;
        }
    }

    .pricing {
        width: 100vw;
        padding: 2rem 3rem;
        overflow: hidden;
        position: relative;
    }

    .pricing .header-page {
        width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 4rem;
    }

    .pricing .header-page h1 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .pricing .header-page h1 span {
        color: #0099ff;
    }

    .pricing .header-page p {
        font-size: 1.25rem;
        text-align: center;
        width: 60%;
        color: #555;
    }

    .pricing .container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .pricing .container .box {
        position: relative;
        width: 25rem;
        margin: 1rem;
        box-shadow: 2px 2px 10px #eee,
            -2px -2px 10px #eee;
        border-radius: 4rem;
        padding: 5rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pricing .box:hover {
        transition: 1s;
        transform: translateY(-30px);
    }

    .pricing .box h3,
    .pricing .box img,
    .pricing .box p {
        margin-bottom: 2rem;
    }

    .pricing .box h3 {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .pricing .box p {
        font-size: 1.25rem;
        text-align: center;
        color: #555;
    }

    .pricing .box span {
        color: #0099ff;
    }

    .pricing .box .top-left {
        display: inline-block;
        position: absolute;
        top: 1.5rem;
        left: 1rem;
        font-size: 2.5rem;
        font-weight: 900;
    }

    .pricing .box button {
        padding: .6rem 1.6rem;
        border: 2px solid #0099ff;
        border-radius: 3rem;
        background: #fff;
        margin-right: 2rem;
    }

    .pricing .box button a {
        text-decoration: none;
        font-size: 1.25rem;
        color: #333;
        font-weight: 700;
    }

    .pricing .box button:hover {
        background: #0099ff;
        border: 2px solid #0099ff;
        transition: .75s;
    }

    .pricing .box button:hover a {
        color: #fff;
        transition: .75s;
    }

    @media (max-width: 767px) {
        .pricing {
            display: flex;
            justify-content: space-evenly;
            flex-direction: column;
            align-items: center;
        }

        .pricing .img {
            width: 100%;
            position: static;
        }

        .pricing .container {
            width: 120%;
        }

        .pricing .container .box {
            width: 80%;
        }
    }

    .footer {
        width: 100vw;
        padding: 2rem 4rem;
        background: #0099ff;
        color: #fff;
        font-weight: 500;
    }

    .footer h1 {
        font-size: 2rem;
        margin: 1rem 0;
        margin-left: -1rem;
    }

    .footer span {
        font-size: 1.25rem;
    }

    .footer .p1 {
        margin: 1rem -1rem;
        font-size: 1.25rem;
        text-align: center;
    }

    .footer .p2 {
        font-size: 1.25rem;
        text-align: center;
        font-weight: 900;
    }
</style>

<body>
    <div class="header">
        <div class="logo">
            <h1 style="color: peru">HORUS-HEALTH</h1>
            {{-- <img src="images/v-logo.png" style="height: 59px;"> --}}
        </div>
        <div class="nav">
            <ul>
                <li><a href="#">Inicio</a></li>
                {{-- <li><a href="#services">Servicios</a></li>
                <li><a href="#about">Nosotros</a></li>
                <li><a href="#price">Precios</a></li> --}}
            </ul>
            <div class="button">
                <button><a href="https://sumi.horus-health.com/">Iniciar Sesion</a></button>
            </div>
        </div>
    </div>
    <div class="home" id="home">
        <div class="content">
            <h1>Plataforma de servicios en SALUD</h1>
            <p style="font-size: 15px">Horus-Health garantiza que la atención médica esté al alcance de todos, eliminando las barreras tradicionales como largas esperas y desplazamientos innecesarios.
                A través de nuestra plataforma, los usuarios pueden conectarse con profesionales de la salud desde la comodidad de su hogar,
                mediante consultas virtuales que aseguran atención inmediata y personalizada.
            </p>
            <div class="buttons">
                <button><a href="#">Somos
                        <i class='bx bxl-apple'></i></a></button>
                <button><a href="#">Salud
                        <i class='bx bxl-play-store'></i></a></button>
            </div>
        </div>
        <div class="img-right">
            <img src="https://templatemo.com/templates/templatemo_570_chain_app_dev/assets/images/slider-dec.png">
        </div>
    </div>
    {{-- <div class="services" id="services">
        <div class="header-page">
            <h1>Amazing <span>Services & Features</span> For You</h1>
            <p>If you need the greatest collection of HTML templates for your business, please visit TooCSS Blog. If you
                need to have a contact form PHP script, go to our contact page for more information.</p>
        </div>
        <div class="container-box">
            <div class="box">
                <i class='bx bx-cog'></i>
                <h2>App Maintenance</h2>
                <p>You are not allowed to redistribute this template ZIP file on any other website.</p>
                <button><a href="#">Read More</a></button>
            </div>
            <div class="box">
                <i class='bx bxs-rocket'></i>
                <h2>Rocket Speed of App</h2>
                <p>You are allowed to use the Chain App Dev HTML template. Feel free to modify or edit this layout.</p>
                <button><a href="#">Read More</a></button>
            </div>
            <div class="box">
                <i class='bx bx-vector'></i>
                <h2>Multi Workflow Idea</h2>
                <p>If this template is beneficial for your work, please support us a little via PayPal. Thank you.</p>
                <button><a href="#">Read More</a></button>
            </div>
            <div class="box">
                <i class='bx bx-support'></i>
                <h2>24/7 Help & Support</h2>
                <p>Lorem ipsum dolor consectetur adipiscing elit sedder williamsburg photo booth quinoa and fashion axe.
                </p>
                <button><a href="#">Read More</a></button>
            </div>
        </div>
    </div>
    <div class="about" id="about">
        <div class="header-page">
            <h1>About <span>What We Do</span> & Who We Are</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eismod tempor incididunt ut labore et
                dolore magna.</p>
        </div>
        <div class="content">
            <div class="cont-box">
                <div class="box">
                    <h3>Maintance Problems</h3>
                    <p>Lorem Ipsum Text</p>
                </div>
                <div class="box">
                    <h3>24/7 Support & Help</h3>
                    <p>Lorem Ipsum Text</p>
                </div>
                <div class="box">
                    <h3>Fixing Issues About</h3>
                    <p>Lorem Ipsum Text</p>
                </div>
                <div class="box">
                    <h3>Co. Development</h3>
                    <p>Lorem Ipsum Text</p>
                </div>
            </div>
        </div>
        <div class="pbp">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eismod tempor idunte ut labore et dolore
                adipiscing magna.</p>
            <button><a href="#">Start 14-Day Free Trial</a></button>
            <p>*No Credit Card Required</p>
        </div>
        <div class="img">
            <img src="https://templatemo.com/templates/templatemo_570_chain_app_dev/assets/images/about-right-dec.png">
        </div>
    </div>
    <div class="pricing" id="price">
        <div class="header-page">
            <h1>We Have The Best Pre-Order <span>Prices</span> You Can Get</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eismod tempor incididunt ut labore et
                dolore magna.</p>
        </div>
        <div class="container">
            <div class="box">
                <h3>Standard Plan App</h3>
                <span class="top-left">$12</span>
                <img
                    src="https://templatemo.com/templates/templatemo_570_chain_app_dev/assets/images/pricing-table-01.png">
                <p>
                    <span>
                        Lorem Ipsum Dolores<br>
                        50 TB of Storage<br>
                    </span>
                    <del>Life-time Support</del><br>
                    <del>Premium Add-Ons</del><br>
                    <del>Fastest Network</del><br>
                    <del>More Options</del><br>
                </p>
                <button><a href="#">Purchase This Plan Now</a></button>
            </div>
            <div class="box">
                <h3>Business Plan App</h3>
                <span class="top-left">$25</span>
                <img
                    src="https://templatemo.com/templates/templatemo_570_chain_app_dev/assets/images/pricing-table-01.png">
                <p>
                    <span>
                        Lorem Ipsum Dolores<br>
                        20 TB of Storage<br>
                        Premium Add-Ons<br>
                        Life-time Support<br>
                    </span>
                    <del>Fastest Network</del><br>
                    <del>More Options</del><br>
                </p>
                <button><a href="#">Purchase This Plan Now</a></button>
            </div>
            <div class="box">
                <h3>Premium Plan App</h3>
                <span class="top-left">$66</span>
                <img
                    src="https://templatemo.com/templates/templatemo_570_chain_app_dev/assets/images/pricing-table-01.png">
                <p>
                    <span>
                        Lorem Ipsum Dolores<br>
                        120 TB of Storage<br>
                        Life-time Support<br>
                        Premium Add-Ons<br>
                        Fastest Network<br>
                        More Options<br>
                    </span>
                </p>
                <button><a href="#">Purchase This Plan Now</a></button>
            </div>
        </div>
    </div>
    <div class="footer">
        <h1>Contact Us</h1>
        <span>
            Rio de Janeiro - RJ, 22795-008, Brazil<br>
            010-020-0340<br>
            info@company.co<br>
        </span>
        <h1>About Us</h1>
        <span>
            Home<br>
            services<br>
            about<br>
            pricing<br>
        </span>
        <h1>Useful Links</h1>
        <span>
            Free Apps<br>
            App Engine<br>
            Programming<br>
            Development<br>
            App News<br>
            App Dev Team<br>
            Digital Web<br>
            Normal Apps<br>
        </span>
        <p class="p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore.</p>
        <p class="p2">Copyright © 2022 Chain App Dev Company. All Rights Reserved.
            Designer: Ahmed Mohamed</p>
    </div> --}}
</body>

</html>
