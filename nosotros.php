<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros | Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header>
          <?php  require_once 'header.php'; ?>
    </header>
    <main>
        <section class="hero hero-nosotros" id="hero-nosotros">
            <h1>Sobre Nosotros</h1>
            <p>Conoce la historia, misión y valores que nos inspiran a crear experiencias familiares únicas en Family Lunch Spa.</p>
        </section>

        <section class="section nosotros-historia">
            <div class="section-title">Nuestra Historia</div>
            <div class="section-desc">Más de 10 años reuniendo familias en torno a la mesa</div>
            <div class="nosotros-historia-content">
                <div class="nosotros-historia-text">
                    <p>
                        Family Lunch Spa nació del sueño de una familia chilena que buscaba un lugar donde grandes y pequeños pudieran disfrutar juntos de la buena mesa. Desde nuestros inicios, hemos trabajado para ofrecer un ambiente cálido, seguro y divertido, donde cada detalle está pensado para el bienestar de toda la familia.
                    </p>
                    <p>
                        Nuestra pasión por la gastronomía y el servicio nos ha permitido crecer y convertirnos en un referente de experiencias familiares, manteniendo siempre la esencia de un trato cercano y personalizado.
                    </p>
                </div>
                <figure class="nosotros-historia-img">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80" alt="Paella Familiar">
                </figure>
            </div>
        </section>

        <section class="section nosotros-valores">
            <div class="section-title">Nuestros Valores</div>
            <div class="section-desc">Lo que nos mueve día a día</div>
            <div class="beneficios nosotros-valores-list">
                <div class="beneficio">
                    <i class="bi bi-heart-fill"></i>
                    <h4>Calidez Humana</h4>
                    <p>Atendemos a cada familia como si fuera parte de la nuestra, con cariño y dedicación.</p>
                </div>
                <div class="beneficio">
                    <i class="bi bi-emoji-smile"></i>
                    <h4>Ambiente Familiar</h4>
                    <p>Creamos espacios seguros y entretenidos para que niños y adultos disfruten juntos.</p>
                </div>
                <div class="beneficio">
                    <i class="bi bi-egg-fried"></i>
                    <h4>Calidad Gastronómica</h4>
                    <p>Seleccionamos ingredientes frescos y recetas caseras para ofrecer platos deliciosos y saludables.</p>
                </div>
                <div class="beneficio">
                    <i class="bi bi-globe"></i>
                    <h4>Inclusión</h4>
                    <p>Nos esforzamos por ser un lugar accesible y acogedor para todas las familias.</p>
                </div>
            </div>
        </section>

        <section class="section nosotros-equipo">
            <div class="section-title">Nuestro Equipo</div>
            <div class="section-desc">Personas comprometidas con tu experiencia</div>
            <div class="nosotros-equipo-list">
                <div class="nosotros-equipo-card">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Gerente General">
                    <h4>Juan Pérez</h4>
                    <p>Gerente General</p>
                </div>
                <div class="nosotros-equipo-card">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Chef Ejecutiva">
                    <h4>María González</h4>
                    <p>Chef Ejecutiva</p>
                </div>
                <div class="nosotros-equipo-card">
                    <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Encargado de Zona Infantil">
                    <h4>Carlos Soto</h4>
                    <p>Encargado Zona Infantil</p>
                </div>
                <div class="nosotros-equipo-card">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Relaciones Públicas">
                    <h4>Fernanda Ruiz</h4>
                    <p>Relaciones Públicas</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>Family Lunch Spa</h4>
                <p>¡Haz parte de la familia! Síguenos en nuestras redes sociales:</p>
                <div class="footer-social">
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="index.html#section-menu">Menús</a></li>
                    <li><a href="index.html#hero">Reservas</a></li>
                    <li><a href="#">Pedidos Online</a></li>
                    <li><a href="index.html#experiencia">Experiencia Familiar</a></li>
                    <li><a href="#">Eventos y Promociones</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Horarios</h4>
                <ul>
                    <li>Lunes - Viernes: <b>12:00 - 22:00</b></li>
                    <li>Sábado: <b>10:00 - 22:00</b></li>
                    <li>Domingo: <b>12:00 - 19:00</b></li>
                    <li>Brunch (fin de semana): <b>13:00</b></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <ul>
                    <li>Av. Principal 1234, Ciudad</li>
                    <li>+ 662 2345 6789</li>
                    <li><a href="mailto:info@familylunch.co">info@familylunch.co</a></li>
                </ul>
                <div class="newsletter">
                    <form>
                        <input type="email" placeholder="Tu email">
                        <button type="submit" class="btn-newsletter">Suscribirse</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            © 2023 Family Lunch Spa. Todos los derechos reservados | 
            <a href="#" class="footer-link">Política de Privacidad</a> | 
            <a href="#" class="footer-link">Términos y Condiciones</a>
        </div>
    </footer>
        <script src="assets/js/modal-contacto.js"></script>
</body>
</html>