<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de seguimiento profesional de egresados del Instituto Superior Universitario Tecnológico Sucre">

    <title>Sistema de Egresados Institucional | SEI</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|open-sans:400,500,600" rel="stylesheet" />

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* This is a temporary style for demonstration. For production, add this to your main CSS file or a dedicated utility. */
        .btn-soft-primary {
            @apply bg-primary-light text-primary-dark hover:bg-primary-lightest focus:ring-primary;
        }
        /* Custom footer background color to match your design system if 'dark' isn't defined or needs a specific shade */
        .bg-dark {
            background-color: #1a202c; /* Example: A dark gray, adjust if you have a specific 'dark' color in your Tailwind config */
        }
    </style>
</head>
<body class="font-body text-text-primary bg-bg-primary leading-relaxed antialiased">
    <header class="bg-primary text-white py-4 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="/" class="flex items-center group" aria-label="Volver al inicio de SEI">
                <img src="https://tecnologicosucre.edu.ec/web/wp-content/uploads/2025/02/logo_isu-bl.png" alt="ISUS Logo" class="h-12 mr-4 transition-transform duration-300 group-hover:scale-105">
                <span class="text-xl font-bold hidden md:block font-headings tracking-tight">Sistema de Egresados Institucional</span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center space-x-4" aria-label="Navegación principal">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline text-white hover:bg-white hover:text-primary transition-colors duration-200" aria-label="Ir al Dashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
   class="btn bg-white text-primary font-semibold px-5 py-2 rounded-xl shadow hover:bg-primary-light hover:text-primary-dark transition-colors duration-200"
   aria-label="Iniciar sesión">
   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
       <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
   </svg>
   Iniciar Sesión
</a>


                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-accent transition-colors duration-200" aria-label="Registrarse">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main>
        <section class="py-20 md:py-32 bg-gradient-to-br from-primary-dark to-primary">
            <div class="container mx-auto text-center px-4">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-white font-headings leading-tight">Seguimiento Profesional de Egresados</h1>
                <p class="text-xl md:text-2xl mb-10 max-w-4xl mx-auto text-primary-lightest leading-relaxed">
                    Conectamos a nuestros graduados con oportunidades profesionales, acompañando su crecimiento laboral y generando información estratégica que fortalece la calidad académica y potencia la empleabilidad futura.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                    <a href="{{ route('login') }}"
   class="btn-primary font-bold text-lg px-8 py-3 rounded-xl shadow transition duration-300
          hover:bg-primary-dark hover:text-white hover:shadow-lg hover:scale-105"
   aria-label="Acceder al Sistema de Egresados">


                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline-block" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Acceder al Sistema
                    </a>
                </div>

                <div class="card max-w-4xl mx-auto py-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                        <div>
                            <div class="text-5xl font-bold text-primary mb-2 font-headings">2,400</div>
                            <div class="text-gray-600 text-lg">Estudiantes</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold text-primary mb-2 font-headings">146</div>
                            <div class="text-gray-600 text-lg">Docentes</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold text-primary mb-2 font-headings">12</div>
                            <div class="text-gray-600 text-lg">Carreras</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold text-primary mb-2 font-headings">10,000</div>
                            <div class="text-gray-600 text-lg">Graduados</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="features" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 font-headings">
                        Potencia tu Trayectoria Profesional
                    </h2>
                    <p class="text-lg text-gray-600">
                        Nuestra plataforma ofrece herramientas innovadoras y confiables para acompañar el crecimiento profesional de nuestros egresados.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-3 max-w-6xl mx-auto">
                    <div class="card flex flex-col items-center text-center h-full p-6">
                        <div class="text-primary-dark text-6xl mb-6 flex-shrink-0">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                class="w-14 h-14 mx-auto"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 font-headings">
                            Perfil Profesional Actualizado
                        </h3>
                        <p class="text-text-secondary mb-6 flex-grow">
                            Crea y mantiene un perfil detallado que refleja tu experiencia, habilidades y trayectoria laboral, accesible para empleadores e instituciones.
                        </p>
                        <ul class="text-gray-600 space-y-3 list-inside list-disc text-left w-full pl-6">
                            <li>Actualiza tu situación laboral y sector profesional</li>
                            <li>Comparte logros y certificaciones relevantes</li>
                            <li>Sube y gestiona tu CV y portafolio digital</li>
                        </ul>
                    </div>

                    <div class="card flex flex-col items-center text-center h-full p-6">
                        <div class="text-green-600 text-6xl mb-6 flex-shrink-0">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                class="w-14 h-14 mx-auto"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6v-10m4 10v-4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 font-headings">
                            Estadísticas y Reportes Personalizados
                        </h3>
                        <p class="text-text-secondary mb-6 flex-grow">
                            Accede a análisis precisos y actualizados del mercado laboral, que te permiten tomar decisiones informadas sobre tu carrera.
                        </p>
                        <ul class="text-gray-600 space-y-3 list-inside list-disc text-left w-full pl-6">
                            <li>Comparación salarial por especialidad y experiencia</li>
                            <li>Identificación de sectores laborales con mayor demanda</li>
                            <li>Exportación de reportes en formatos PDF y Excel</li>
                        </ul>
                    </div>

                    <div class="card flex flex-col items-center text-center h-full p-6">
                        <div class="text-purple-600 text-6xl mb-6 flex-shrink-0">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                class="w-14 h-14 mx-auto"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 font-headings">
                            Red Profesional y Oportunidades Exclusivas
                        </h3>
                        <p class="text-text-secondary mb-6 flex-grow">
                            Conéctate con otros egresados, accede a ofertas laborales exclusivas y participa en eventos para ampliar tu red profesional.
                        </p>
                        <ul class="text-gray-600 space-y-3 list-inside list-disc text-left w-full pl-6">
                            <li>Recibe ofertas laborales y convocatorias especiales</li>
                            <li>Participa en webinars y eventos exclusivos</li>
                            <li>Accede a mentorías personalizadas para tu desarrollo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-br from-blue-50 to-blue-100">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 font-headings">Impacto en la Trayectoria Profesional</h2>
                    <p class="text-lg text-gray-600">
                        Descubre cómo este sistema apoya y potencia el desarrollo profesional de nuestros egresados.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-2 max-w-5xl mx-auto">
                    <div class="card flex items-start space-x-6 p-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m0 0a3 3 0 010-6h6a3 3 0 010 6m-6 0a3 3 0 00-6 0v3a3 3 0 006 0v-3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 font-headings">Conexión directa con empleadores</h3>
                            <p class="text-text-secondary leading-relaxed">
                                Facilitamos el acceso a oportunidades laborales relevantes, vinculando perfiles especializados con empresas del sector tecnológico.
                            </p>
                        </div>
                    </div>

                    <div class="card flex items-start space-x-6 p-6">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-4 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6v-10m4 10v-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 font-headings">Datos para decisiones profesionales</h3>
                            <p class="text-text-secondary leading-relaxed">
                                Proveemos estadísticas actualizadas que permiten a los egresados conocer su valor en el mercado y orientar su crecimiento profesional.
                            </p>
                        </div>
                    </div>

                    <div class="card flex items-start space-x-6 p-6">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-4 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.255a1 1 0 00.95.69h6.572c.969 0 1.371 1.24.588 1.81l-5.32 3.862a1 1 0 00-.364 1.118l2.036 6.255c.3.921-.755 1.688-1.54 1.118l-5.32-3.862a1 1 0 00-1.175 0l-5.32 3.862c-.784.57-1.838-.197-1.54-1.118l2.036-6.255a1 1 0 00-.364-1.118L2.383 11.682c-.783-.57-.38-1.81.588-1.81h6.572a1 1 0 00.95-.69l2.036-6.255z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 font-headings">Desarrollo de habilidades clave</h3>
                            <p class="text-text-secondary leading-relaxed">
                                Identificamos las competencias más demandadas para que nuestros egresados enfoquen su aprendizaje y aumenten su competitividad.
                            </p>
                        </div>
                    </div>

                    <div class="card flex items-start space-x-6 p-6">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-4 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 16v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h14l4 4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 font-headings">Comunicación permanente con el instituto</h3>
                            <p class="text-text-secondary leading-relaxed">
                                Manténte informado con avisos sobre encuestas, eventos, convocatorias y novedades que favorecen tu desarrollo profesional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-primary text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-6 font-headings text-white">Únete a nuestra red profesional</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto text-primary-lightest">
                    Forma parte de esta comunidad que crece día a día y potencia tu carrera profesional.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn btn-accent text-lg px-8 py-3 transition-transform duration-300 hover:scale-105" aria-label="Registrarse ahora">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Registrarse
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="https://tecnologicosucre.edu.ec/web/wp-content/uploads/2025/02/logo_isu-bl.png" alt="ISUS Logo" class="h-12 mb-4">
                    <p class="mb-4 text-gray-300">
                        Instituto Superior Universitario Tecnológico Sucre<br>
                        Quito, Ecuador
                    </p>
                    <p class="text-sm italic text-gray-400">"Tu camino hacia el éxito académico y educación profesional"</p>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4 font-headings text-gray-200">Enlaces útiles</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="https://tecnologicosucre.edu.ec/" class="hover:underline hover:text-primary-light transition-colors duration-200" target="_blank" rel="noopener noreferrer">Portal ISUS</a></li>
                        <li><a href="https://tecnologicosucre.edu.ec/web/oferta-academica/" class="hover:underline hover:text-primary-light transition-colors duration-200" target="_blank" rel="noopener noreferrer">Oferta académica</a></li>
                        <li><a href="https://tecnologicosucre.edu.ec/web/postulate/" class="hover:underline hover:text-primary-light transition-colors duration-200" target="_blank" rel="noopener noreferrer">Postulate</a></li>
                        <li><a href="https://tecnologicosucre.edu.ec/web/category/noticias/" class="hover:underline hover:text-primary-light transition-colors duration-200" target="_blank" rel="noopener noreferrer">Noticias</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4 font-headings text-gray-200">Dirección</h4>

                    <div class="text-gray-300 space-y-6 text-sm leading-relaxed">
                        <div>
                            <strong class="block mb-1 text-white">Campus norte (matriz)</strong>
                            <p>Av. 10 de Agosto N26-27 y Luis Mosquera Narváez</p>
                        </div>

                        <div>
                            <strong class="block mb-1 text-white">Campus sur</strong>
                            <p>Av. Teodoro Gómez de la Torre S14 - 72 y Joaquín Gutiérrez</p>
                        </div>

                        <div>
                            <strong class="block mb-1 text-white">Centro múltiple de institutos (CMI)</strong>
                            <p>Mitad del Mundo - Planta baja</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4 font-headings text-gray-200">Síguenos</h4>
                    <div class="flex space-x-6">
                        <a href="https://www.facebook.com/SUCREInstitutooficial/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="text-gray-300 hover:text-blue-500 transition-colors duration-200">
                            <svg fill="currentColor" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33V22H12c5.523 0 10-4.477 10-10z" />
                            </svg>
                        </a>

                        <a href="https://x.com/SUCREInstituto" target="_blank" rel="noopener noreferrer" aria-label="X (anteriormente Twitter)" class="text-gray-300 hover:text-sky-400 transition-colors duration-200">
                            <svg fill="currentColor" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.954 4.569c-.885.392-1.83.656-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.957-2.178-1.555-3.594-1.555-2.723 0-4.93 2.206-4.93 4.93 0 .39.045.765.127 1.124-4.09-.205-7.719-2.165-10.148-5.144-.423.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.099-.807-.026-1.566-.247-2.228-.616v.062c0 2.388 1.698 4.384 3.946 4.833-.413.112-.849.171-1.296.171-.317 0-.626-.031-.928-.088.627 1.956 2.444 3.379 4.6 3.42-1.68 1.316-3.809 2.101-6.102 2.101-.395 0-.788-.023-1.175-.068 2.179 1.397 4.768 2.213 7.557 2.213 9.054 0 14.002-7.5 14.002-14.002 0-.213-.004-.425-.014-.636.962-.694 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>

                        <a href="https://www.instagram.com/sucreinstituto/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="text-gray-300 hover:text-pink-500 transition-colors duration-200">
                            <svg fill="currentColor" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 2A3.75 3.75 0 004 7.75v8.5A3.75 3.75 0 007.75 20h8.5a3.75 3.75 0 003.75-3.75v-8.5A3.75 3.75 0 0016.25 4h-8.5zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm4.75-3.5a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z" />
                            </svg>
                        </a>

                        <a href="https://www.youtube.com/@tecnologicosucre5610/featured" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="text-gray-300 hover:text-red-600 transition-colors duration-200">
                            <svg fill="currentColor" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M10 15l5.19-3L10 9v6zm10-3c0 1.38-.56 2.61-1.48 3.5-.58.56-1.4.92-2.26.98-3.36.25-6.72.25-10.08 0-.86-.06-1.68-.42-2.26-.98A4.98 4.98 0 012 12a4.98 4.98 0 011.98-4.5c.58-.56 1.4-.92 2.26-.98 3.36-.25 6.72-.25 10.08 0 .86.06 1.68.42 2.26.98A4.98 4.98 0 0120 12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 text-sm text-center text-gray-400">
                &copy; {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre.
            </div>
        </div>
    </footer>
</body>
</html>
