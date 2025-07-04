@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12"> {{-- Aumentado el padding vertical --}}

    {{-- Bienvenida personalizada por rol --}}
    @auth
    <section class="mb-16"> {{-- Mayor margen inferior --}}
        @if(Auth::user()->hasRole('admin'))
            <h1 class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">Bienvenido, Administrador</h1> {{-- Animación de entrada --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16 justify-items-center"> {{-- Mayor espacio entre tarjetas --}}
                {{-- Tarjeta de Gestión de Usuarios --}}
                <div class="w-full">
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 h-full flex flex-col overflow-hidden animate-slide-in-left"> {{-- Bordes más redondeados, sombra más profunda, animación --}}
                        <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80" class="w-full h-52 object-cover rounded-t-2xl" alt="Gestión de Usuarios"> {{-- Mayor altura de imagen --}}
                        <div class="p-7 flex flex-col flex-grow"> {{-- Mayor padding --}}
                            <h5 class="text-dark font-headings font-bold text-2xl mb-4"><i class="bi bi-people-fill mr-3 text-secondary"></i>Gestión de Usuarios</h5> {{-- Icono más grande, espacio --}}
                            <p class="text-text-light font-open-sans text-base flex-grow leading-relaxed"> {{-- Mayor interlineado --}}
                                Administre perfiles de egresados y empleadores con control total para mantener la calidad y seguridad de la plataforma.
                            </p>
                            <a href="#" class="mt-6 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-secondary hover:bg-primary transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                                Ver Usuarios <i class="bi bi-arrow-right ml-2"></i>
                            </a> {{-- Botón de acción --}}
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de Encuestas Laborales --}}
                <div class="w-full">
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 h-full flex flex-col overflow-hidden animate-slide-in-up delay-100">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80" class="w-full h-52 object-cover rounded-t-2xl" alt="Encuestas Laborales">
                        <div class="p-7 flex flex-col flex-grow">
                            <h5 class="text-dark font-headings font-bold text-2xl mb-4"><i class="bi bi-card-checklist mr-3 text-secondary"></i>Encuestas Laborales</h5>
                            <p class="text-text-light font-open-sans text-base flex-grow leading-relaxed">
                                Cree, active y supervise encuestas detalladas para recolectar datos valiosos sobre el desempeño profesional de nuestros egresados.
                            </p>
                            <a href="#" class="mt-6 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-secondary bg-primary-light hover:bg-primary-lighter transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-light">
                                Crear Encuesta <i class="bi bi-plus-circle ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de Reportes y Estadísticas --}}
                <div class="w-full">
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 h-full flex flex-col overflow-hidden animate-slide-in-right delay-200">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80" class="w-full h-52 object-cover rounded-t-2xl" alt="Reportes y Estadísticas">
                        <div class="p-7 flex flex-col flex-grow">
                            <h5 class="text-dark font-headings font-bold text-2xl mb-4"><i class="bi bi-bar-chart-line-fill mr-3 text-secondary"></i>Reportes y Estadísticas</h5>
                            <p class="text-text-light font-open-sans text-base flex-grow leading-relaxed">
                                Genere indicadores clave y reportes dinámicos para apoyar decisiones basadas en datos reales y actualizados, mejorando la oferta académica.
                            </p>
                            <a href="#" class="mt-6 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-secondary bg-yellow-accent-light hover:bg-yellow-accent-lighter transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-accent">
                                Ver Reportes <i class="bi bi-graph-up ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->hasRole('graduate'))
            <h1 class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">Bienvenido, Egresado</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16 justify-items-center">
                {{-- Tarjeta de Actualización de Perfil --}}
                <div class="w-full">
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 h-full flex flex-col overflow-hidden animate-slide-in-left">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover rounded-t-2xl" alt="Perfil Profesional"> {{-- Mayor altura de imagen --}}
                        <div class="p-7 flex flex-col flex-grow">
                            <h5 class="text-dark font-headings font-bold text-2xl mb-4"><i class="bi bi-person-badge-fill mr-3 text-secondary"></i>Actualización de Perfil</h5>
                            <p class="text-text-light font-open-sans text-base flex-grow leading-relaxed">
                                Mantenga su información actualizada: empresa, cargo, salario y habilidades técnicas que reflejan su valiosa trayectoria laboral.
                            </p>
                            <a href="#" class="mt-6 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-secondary hover:bg-primary transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                                Editar Perfil <i class="bi bi-pencil-square ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de Participación en Encuestas --}}
                <div class="w-full">
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 h-full flex flex-col overflow-hidden animate-slide-in-right delay-100">
                        <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover rounded-t-2xl" alt="Encuestas">
                        <div class="p-7 flex flex-col flex-grow">
                            <h5 class="text-dark font-headings font-bold text-2xl mb-4"><i class="bi bi-clipboard-check-fill mr-3 text-secondary"></i>Participación en Encuestas</h5>
                            <p class="text-text-light font-open-sans text-base flex-grow leading-relaxed">
                                Su participación es crucial para la mejora continua de la formación y la relevancia del programa académico que lo vio crecer.
                            </p>
                            <a href="#" class="mt-6 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-secondary bg-yellow-accent-light hover:bg-yellow-accent-lighter transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-accent">
                                Realizar Encuesta <i class="bi bi-question-circle ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->hasRole('employer'))
            <h1 class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">Bienvenido, Empleador</h1>
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-4xl transform hover:-translate-y-3 transition-all duration-300 max-w-4xl mx-auto mb-16 flex flex-col overflow-hidden animate-fade-in"> {{-- Más ancho, bordes más redondos, animación --}}
                <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1200&q=80" class="w-full h-80 object-cover rounded-t-2xl" alt="Estadísticas Laborales"> {{-- Mayor altura de imagen --}}
                <div class="p-8 flex flex-col flex-grow"> {{-- Mayor padding --}}
                    <h5 class="text-dark font-headings font-bold text-3xl text-center mb-5"><i class="bi bi-graph-up-arrow mr-3 text-secondary"></i>Acceso a Estadísticas y Reportes</h5> {{-- Icono más grande, espacio --}}
                    <p class="text-xl text-text-light text-center font-open-sans flex-grow leading-relaxed">
                        Visualice información agregada crucial sobre empleabilidad, sectores predominantes y tendencias salariales para apoyar la valiosa colaboración entre el sector productivo y el Instituto Sucre.
                    </p>
                    <a href="#" class="mt-8 inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl shadow-md text-white bg-primary hover:bg-primary-dark transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Explorar Datos <i class="bi bi-bar-chart-fill ml-3"></i>
                    </a> {{-- Botón de acción más grande --}}
                </div>
            </div>

        @else
            <p class="text-center text-red-600 text-xl mt-12 font-semibold font-open-sans animate-fade-in">
                Su rol no está reconocido en el sistema. Por favor, contacte al administrador para resolver esta situación.
            </p>
        @endif
    </section>
    @else
    <p class="text-center text-xl mt-12 text-text-light font-open-sans animate-fade-in">
        Para acceder al sistema y descubrir sus funcionalidades, por favor, inicie sesión con sus credenciales.
    </p>
    @endauth

    <div class="border-t border-gray-300 my-12 w-2/3 mx-auto"></div> {{-- Separador más sutil y centrado --}}

    {{-- Presentación general del proyecto --}}
    <div class="text-center mb-16 pt-8"> {{-- Mayor margen y padding --}}
        <h1 class="font-bold text-primary font-headings text-4xl lg:text-6xl mb-4 animate-fade-in-down"> {{-- Título más grande --}}
            <i class="bi bi-box-seam mr-4 text-yellow-accent"></i>Sistema de Seguimiento Profesional de Egresados
        </h1>
        <p class="text-xl lg:text-2xl text-text-light font-open-sans mt-4 max-w-4xl mx-auto animate-fade-in delay-200">Una solución integral para potenciar el futuro profesional del Instituto Superior Universitario Tecnológico Sucre.</p> {{-- Texto más descriptivo --}}
        <hr class="w-24 border-t-4 border-secondary mx-auto my-8 opacity-100"> {{-- Separador más grande --}}
    </div>

    {{-- Descripción general --}}
    <section class="mb-16 px-6 max-w-4xl mx-auto"> {{-- Mayor margen, padding horizontal y ancho --}}
        <h2 class="mb-8 text-primary font-headings font-bold text-4xl text-center animate-fade-in-left"> {{-- Título más grande y centrado --}}
            <i class="bi bi-info-circle-fill mr-4 text-yellow-accent"></i>¿Qué es?
        </h2>
        <p class="text-xl max-w-3xl mx-auto text-text-light font-open-sans text-center mb-10 animate-fade-in delay-300">
            Esta aplicación web profesional, innovadora y robusta, permitirá al Instituto Superior Universitario Tecnológico Sucre:
        </p>

        <ul class="list-none mb-10 max-w-3xl mx-auto space-y-6 mt-8"> {{-- Mayor espacio entre elementos --}}
            <li class="flex items-start py-4 bg-white rounded-xl shadow-md px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-400"> {{-- Mayor padding, sombra más suave, efecto de escala al hover --}}
                <i class="bi bi-check-circle-fill text-3xl mr-5 flex-shrink-0 text-secondary"></i> {{-- Icono más grande, mayor espacio --}}
                <span class="text-text-light font-open-sans text-lg leading-relaxed">Registrar, centralizar y gestionar de manera eficiente la información profesional detallada de sus egresados de la carrera de Desarrollo de Software.</span>
            </li>
            <li class="flex items-start py-4">
                <i class="bi bi-check-circle-fill text-3xl mr-5 flex-shrink-0 text-secondary"></i>
                <span class="text-text-light font-open-sans text-lg leading-relaxed">Recolectar y analizar datos exhaustivos sobre el empleo actual, habilidades adquiridas, sector laboral y ubicación geográfica de sus graduados, obteniendo una visión completa.</span>
            </li>
            <li class="flex items-start py-4 bg-white rounded-xl shadow-md px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-500">
                <i class="bi bi-check-circle-fill text-3xl mr-5 flex-shrink-0 text-secondary"></i>
                <span class="text-text-light font-open-sans text-lg leading-relaxed">Generar reportes e indicadores clave de desempeño laboral y empleabilidad, proporcionando información valiosa para apoyar decisiones académicas e institucionales estratégicas.</span>
            </li>
            <li class="flex items-start py-4">
                <i class="bi bi-check-circle-fill text-3xl mr-5 flex-shrink-0 text-secondary"></i>
                <span class="text-text-light font-open-sans text-lg leading-relaxed">Facilitar una comunicación fluida y eficiente con los egresados mediante mensajes internos y notificaciones personalizadas, fortaleciendo el vínculo de la comunidad Sucre.</span>
            </li>
            <li class="flex items-start py-4 bg-white rounded-xl shadow-md px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-600">
                <i class="bi bi-check-circle-fill text-3xl mr-5 flex-shrink-0 text-secondary"></i>
                <span class="text-text-light font-open-sans text-lg leading-relaxed">Garantizar la máxima confidencialidad y seguridad de todos los datos personales y laborales, aplicando las mejores prácticas en protección de la información.</span>
            </li>
        </ul>
    </section>

    <div class="border-t border-gray-300 my-12 w-2/3 mx-auto"></div>

    {{-- Objetivos generales y específicos --}}
    <section class="mb-16 bg-white p-10 rounded-2xl shadow-2xl max-w-4xl mx-auto animate-fade-in-up"> {{-- Mayor padding, sombra más profunda, bordes más redondeados --}}
        <h2 class="mb-8 text-center font-bold text-primary font-headings text-4xl">
            <i class="bi bi-bullseye mr-4 text-yellow-accent"></i>Objetivo General
        </h2>
        <p class="text-xl text-center text-text-light mb-12 font-open-sans max-w-3xl mx-auto leading-relaxed">
            Desarrollar un sistema web altamente responsivo y seguro que permita registrar, gestionar y analizar de forma integral los datos laborales, fortaleciendo así el vínculo duradero con nuestros valiosos egresados.
        </p>

        <h3 class="mt-10 mb-8 text-center font-bold text-primary font-headings text-3xl">
            <i class="bi bi-list-check mr-4 text-yellow-accent"></i>Objetivos Específicos
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10"> {{-- Mayor espacio entre tarjetas --}}
            {{-- Objetivo 1 --}}
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 h-full flex flex-col animate-slide-in-left delay-100">
                    <div class="bg-gradient-to-r from-secondary to-primary-dark text-white font-bold text-2xl px-8 py-5 rounded-t-xl font-headings flex items-center"> {{-- Gradiente, mayor padding, texto más grande --}}
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white text-primary mr-4 font-bold text-xl flex-shrink-0">1</span>Analizar las necesidades
                    </div>
                    <div class="p-7"> {{-- Mayor padding --}}
                        <ul class="list-none mb-0 space-y-4 font-open-sans text-lg"> {{-- Mayor espacio, texto más grande --}}
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Levantamiento exhaustivo de requerimientos funcionales y no funcionales.</span></li>
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Realización de entrevistas clave a egresados, empleadores y personal administrativo.</span></li>
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Identificación de datos clave para un monitoreo y análisis precisos del desempeño profesional.</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Objetivo 2 --}}
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 h-full flex flex-col animate-slide-in-right delay-200">
                    <div class="bg-gradient-to-r from-secondary to-primary-dark text-white font-bold text-2xl px-8 py-5 rounded-t-xl font-headings flex items-center">
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white text-primary mr-4 font-bold text-xl flex-shrink-0">2</span>Diseñar la solución
                    </div>
                    <div class="p-7">
                        <ul class="list-none mb-0 space-y-4 font-open-sans text-lg">
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Diseño de un Diagrama ER y una base de datos relacional altamente optimizada.</span></li>
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Definición de una arquitectura técnica MVC clara, modular y escalable.</span></li>
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Creación de wireframes y un diseño visual atractivo alineado con la identidad institucional.</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Objetivo 3 --}}
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 h-full flex flex-col animate-slide-in-left delay-300">
                    <div class="bg-gradient-to-r from-secondary to-primary-dark text-white font-bold text-2xl px-8 py-5 rounded-t-xl font-headings flex items-center">
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white text-primary mr-4 font-bold text-xl flex-shrink-0">3</span>Programar el sistema
                    </div>
                    <div class="p-7">
                        <ul class="list-none mb-0 space-y-4 font-open-sans text-lg">
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Desarrollo de módulos esenciales y modulares: autenticación segura, gestión de perfiles, encuestas dinámicas, dashboard interactivo, comunicación y un panel administrativo robusto.</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Objetivo 4 --}}
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 h-full flex flex-col animate-slide-in-right delay-400">
                    <div class="bg-gradient-to-r from-secondary to-primary-dark text-white font-bold text-2xl px-8 py-5 rounded-t-xl font-headings flex items-center">
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white text-primary mr-4 font-bold text-xl flex-shrink-0">4</span>Probar y validar
                    </div>
                    <div class="p-7">
                        <ul class="list-none mb-0 space-y-4 font-open-sans text-lg">
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Ejecución de pruebas rigurosas: unitarias, de integración, de seguridad y de optimización de rendimiento.</span></li>
                            <li class="flex items-start"><i class="bi bi-check-circle-fill text-green-500 mr-3 mt-1 flex-shrink-0"></i><span>Compatibilidad multiplataforma garantizada para una experiencia de usuario consistente en cualquier dispositivo.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="border-t border-gray-300 my-12 w-2/3 mx-auto"></div>

    {{-- Resumen final --}}
    <section class="bg-gradient-to-br from-primary to-secondary text-white text-center py-16 rounded-3xl shadow-3xl mt-16 max-w-4xl mx-auto transform-gpu animate-fade-in-up delay-500"> {{-- Gradiente diagonal, bordes más redondos, sombra más pronunciada, animación con delay --}}
        <h2 class="mb-8 text-4xl lg:text-5xl font-extrabold font-headings animate-pop-in"> {{-- Título más grande, animación pop --}}
            <i class="bi bi-lightbulb-fill mr-4 text-yellow-accent animate-pulse-slow"></i>Resumen Simplificado
        </h2>
        <p class="text-xl max-w-2xl mx-auto mb-10 font-open-sans opacity-95 leading-relaxed animate-fade-in delay-600">
            Esta plataforma integral y de vanguardia empoderará al Instituto Superior Universitario Tecnológico Sucre al permitirle:
        </p>
        <ul class="list-none text-2xl max-w-xl mx-auto space-y-5 font-open-sans"> {{-- Texto más grande, mayor espacio --}}
            <li class="flex items-center justify-center mb-3 animate-slide-in-left delay-700"><i class="bi bi-check2-circle mr-4 text-yellow-accent"></i><span>Registrar y mantener actualizados los datos laborales de sus egresados.</span></li>
            <li class="flex items-center justify-center mb-3 animate-slide-in-right delay-800"><i class="bi bi-check2-circle mr-4 text-yellow-accent"></i><span>Recoger valiosas opiniones mediante encuestas para una mejora continua del programa académico.</span></li>
            <li class="flex items-center justify-center mb-3 animate-slide-in-left delay-900"><i class="bi bi-check2-circle mr-4 text-yellow-accent"></i><span>Generar reportes y métricas estratégicas para una toma de decisiones informada.</span></li>
            <li class="flex items-center justify-center mb-3 animate-slide-in-right delay-1000"><i class="bi bi-check2-circle mr-4 text-yellow-accent"></i><span>Mantener un contacto eficiente y profesional con los exalumnos, fortaleciendo nuestra comunidad.</span></li>
        </ul>
        <p class="mt-10 text-lg italic opacity-85 font-open-sans animate-fade-in delay-1100">
            Todo esto con el objetivo supremo de mejorar significativamente la gestión académica y la empleabilidad futura de nuestros valiosos graduados, basándose en datos claros, precisos y siempre actualizados.
        </p>
    </section>

</div>
@endsection
