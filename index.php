<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body>
    <header>
      <?php  include_once 'header.php'; ?>
        
    </header>

    <main>
        <section class="hero" id="hero">
            <h1>
                Bienvenidos a Family Lunch Spa
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <span class="bienvenida-cliente">
                        | Bienvenido, <?php echo htmlspecialchars($_SESSION['cliente_nombre']); ?>
                    </span>
                <?php endif; ?>
            </h1>
            <p>Donde cada comida se convierte en una experiencia familiar inolvidable. Disfruta de nuestra gastronomía en un ambiente pensado para toda la familia.</p>
            <div class="reserva-rapida">
                <h2 class="titulo-reserva">Reserva Rápida</h2>
                <form class="reserva-form">
                    <input type="date" placeholder="Fecha">
                    <input type="time" value="12:30">
                    <input type="number" min="1" max="20" placeholder="Personas">
                </form>
                <button class="btn-orange">Reservar Ahora</button>
            </div>
        </section>

        <section class="section" id="section-menu">
            <div class="section-title">Destacados del Menú</div>
            <div class="section-desc">Descubre nuestras especialidades más populares</div>
            <?php
            // Conexión a la base de datos para destacados
            require_once __DIR__ . '/clases/config.php';
            require_once __DIR__ . '/clases/db.php';

            $db = new db($dbhost, $dbuser, $dbpass, $dbname);

            // Consultar los platos destacados
            $destacados = [
                'especialidad' => null,
                'mas_vendido' => null,
                'infantil' => null
            ];

            // Especialidad
            $res = $db->query("SELECT * FROM menus WHERE me_especialidad = 1 LIMIT 1")->fetchAll();
            if (count($res) > 0) $destacados['especialidad'] = $res[0];
            // Más vendido
            $res = $db->query("SELECT * FROM menus WHERE me_mas_vendido = 1 LIMIT 1")->fetchAll();
            if (count($res) > 0) $destacados['mas_vendido'] = $res[0];
            // Infantil
            $res = $db->query("SELECT * FROM menus WHERE me_infantil = 1 LIMIT 1")->fetchAll();
            if (count($res) > 0) $destacados['infantil'] = $res[0];
            ?>
            <div class="menu-destacados">
                <?php if ($destacados['especialidad']): ?>
                <article class="menu-card">
                    <figure>
                        <img src="<?php echo htmlspecialchars($destacados['especialidad']['me_imagen']); ?>" alt="<?php echo htmlspecialchars($destacados['especialidad']['me_menu']); ?>">
                        <figcaption><?php echo htmlspecialchars($destacados['especialidad']['me_menu']); ?></figcaption>
                    </figure>
                    <div class="info">
                        <div class="etiqueta">Especialidad</div>
                        <h3><?php echo htmlspecialchars($destacados['especialidad']['me_menu']); ?></h3>
                        <p><?php echo htmlspecialchars($destacados['especialidad']['me_resena']); ?></p>
                        <div class="precio">$<?php echo number_format($destacados['especialidad']['me_valor'], 0, ',', '.'); ?></div>
                        <button class="btn-detalles">Ver Detalles</button>
                    </div>
                </article>
                <?php endif; ?>
                <?php if ($destacados['mas_vendido']): ?>
                <article class="menu-card">
                    <figure>
                        <img src="<?php echo htmlspecialchars($destacados['mas_vendido']['me_imagen']); ?>" alt="<?php echo htmlspecialchars($destacados['mas_vendido']['me_menu']); ?>">
                        <figcaption><?php echo htmlspecialchars($destacados['mas_vendido']['me_menu']); ?></figcaption>
                    </figure>
                    <div class="info">
                        <div class="destacado">Más Vendido</div>
                        <h3><?php echo htmlspecialchars($destacados['mas_vendido']['me_menu']); ?></h3>
                        <p><?php echo htmlspecialchars($destacados['mas_vendido']['me_resena']); ?></p>
                        <div class="precio">$<?php echo number_format($destacados['mas_vendido']['me_valor'], 0, ',', '.'); ?></div>
                        <button class="btn-detalles">Ver Detalles</button>
                    </div>
                </article>
                <?php endif; ?>
                <?php if ($destacados['infantil']): ?>
                <article class="menu-card">
                    <figure>
                        <img src="<?php echo htmlspecialchars($destacados['infantil']['me_imagen']); ?>" alt="<?php echo htmlspecialchars($destacados['infantil']['me_menu']); ?>">
                        <figcaption><?php echo htmlspecialchars($destacados['infantil']['me_menu']); ?></figcaption>
                    </figure>
                    <div class="info">
                        <div class="favorito">Favorito Infantil</div>
                        <h3><?php echo htmlspecialchars($destacados['infantil']['me_menu']); ?></h3>
                        <p><?php echo htmlspecialchars($destacados['infantil']['me_resena']); ?></p>
                        <div class="precio">$<?php echo number_format($destacados['infantil']['me_valor'], 0, ',', '.'); ?></div>
                        <button class="btn-detalles">Ver Detalles</button>
                    </div>
                </article>
                <?php endif; ?>
            </div>
            <button class="btn-menu-completo" onclick="window.location.href='menu_completo.php'">Ver Menú Completo</button>
        </section>

        <section class="section experiencia" id="experiencia">
            <div class="section-title">Experiencia Familiar</div>
            <div class="section-desc">Un espacio diseñado para que toda la familia disfrute</div>
            <div class="zona-ninos">
                <figure>
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Zona de Niños">
                    
                </figure>
                <div class="info">
                    <h3>Zona de Niños</h3>
                    <ul>
                        <li>✔ Personal especializado en cuidado infantil</li>
                        <li>✔ Actividades educativas y recreativas</li>
                        <li>✔ Menú especial para niños</li>
                        <li>✔ Instalaciones seguras y adaptadas</li>
                    </ul>
                    <button class="btn-mas">Conocer Más</button>
                </div>
            </div>
            <div class="beneficios">
                <div class="beneficio">
                    <i class="bi bi-people-fill"></i>
                    <h4>Celebraciones Especiales</h4>
                    <p>Organizamos cumpleaños y eventos familiares con decoración personalizada.</p>
                </div>
                <div class="beneficio">
                    <i class="bi bi-universal-access"></i>
                    <h4>Accesibilidad Total</h4>
                    <p>Instalaciones adaptadas para personas con movilidad reducida y adultos mayores.</p>
                </div>
                <div class="beneficio">
                    <i class="bi bi-music-note-beamed"></i>
                    <h4>Ambiente Acogedor</h4>
                    <p>Música ambiental, iluminación cálida y espacios pensados para el confort familiar.</p>
                </div>
            </div>
        </section>

        <section class="testimonios">
            <div class="testimonios-title">Lo que dicen nuestros clientes</div>
            <div class="testimonios-desc">Experiencias reales de familias que nos han visitado</div>
            <div class="testimonios-list">
                <article class="testimonio">
                    <div class="nombre">Carolina Méndez</div>
                    <p>“La zona infantil es increíble. Por primera vez pudimos disfrutar de una comida tranquila mientras nuestros hijos se divertían. La comida deliciosa y el personal muy atento con toda la familia.”</p>
                </article>
                <article class="testimonio">
                    <div class="nombre">Roberto Sanchez</div>
                    <p>“Celebramos el cumpleaños de mi nieto y fue perfecto. La organización, la comida y la atención superaron nuestras expectativas. Todos, desde los más pequeños hasta los abuelos, disfrutamos muchísimo.”</p>
                </article>
                <article class="testimonio">
                    <div class="nombre">Familia Rodríguez</div>
                    <p>“Primera salida con nuestro bebé y fue una experiencia maravillosa. El restaurante cuenta con todas las facilidades para familias con niños pequeños. La comida exquisita y el ambiente muy ameno.”</p>
                </article>
            </div>
            <div class="testimonios-vermas">
                <button class="btn-menu-completo btn-ver-mas-testimonios">Ver Más Testimonios</button>
            </div>
        </section>

        <section class="cta">
            <h2>¿Listo para vivir la experiencia Family Lunch?</h2>
            <p>Reserva ahora y disfruta de momentos inolvidables con tu familia en un ambiente diseñado para el disfrute de todos.</p>
            <div class="cta-btns">
                <button>Reservar Mesa</button>
                <a onclick="window.location.href='menu_completo.php'">Ver Menú</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content" id="contacto">
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
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Menús</a></li>
                    <li><a href="#">Reservas</a></li>
                    <li><a href="#">Pedidos Online</a></li>
                    <li><a href="#">Experiencia Familiar</a></li>
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
                    <li><a href="mailto:info@familylunch.co">info@familylunch.com</a></li>
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

    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/56912345678" class="whatsapp-float" target="_blank" title="Chatea con nosotros por WhatsApp">
      <i class="bi bi-whatsapp"></i>
    </a>

        <script src="assets/js/modal-contacto.js"></script>
</body>
</html>