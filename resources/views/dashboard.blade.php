@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-16 lg:py-20"> {{-- Ajuste: Aumentado el padding vertical y responsivo --}}

        {{-- Bienvenida personalizada por rol --}}
        @auth
            <section class="mb-16"> {{-- Ajuste: Mayor margen inferior --}}
                @if (Auth::user()->hasRole('admin'))
                    <h1
                        class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">
                        Bienvenido, Administrador</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16 justify-items-center">
                        {{-- Ajuste: Mayor espacio entre tarjetas --}}
                        {{-- Tarjeta de Gestión de Usuarios --}}
                        <div class="w-full">
                            <div
                                class="card h-full flex flex-col overflow-hidden animate-slide-in-left border border-primary-lightest">
                                {{-- Aplicado .card, Borde sutil añadido --}}
                                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80"
                                    class="w-full h-52 object-cover rounded-t-2xl" alt="Gestión de Usuarios">
                                <div class="p-7 flex flex-col flex-grow">
                                    <h5 class="text-text-primary font-headings font-bold text-2xl mb-4">Gestión de Usuarios</h5>
                                    {{-- Aplicado text-text-primary --}}
                                    <p class="text-text-light font-body text-base flex-grow leading-relaxed">
                                        {{-- Aplicado font-body --}}
                                        Administre perfiles de egresados y empleadores con control total para mantener la
                                        calidad y seguridad de la plataforma.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Encuestas Laborales --}}
                        <div class="w-full">
                            <div
                                class="card h-full flex flex-col overflow-hidden animate-slide-in-up delay-100 border border-primary-lightest">
                                {{-- Aplicado .card, Borde sutil añadido --}}
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80"
                                    class="w-full h-52 object-cover rounded-t-2xl" alt="Encuestas Laborales">
                                <div class="p-7 flex flex-col flex-grow">
                                    <h5 class="text-text-primary font-headings font-bold text-2xl mb-4"><i
                                            class="bi bi-card-checklist mr-3 text-secondary"></i>Encuestas Laborales</h5>
                                    {{-- Aplicado text-text-primary --}}
                                    <p class="text-text-light font-body text-base flex-grow leading-relaxed">
                                        {{-- Aplicado font-body --}}
                                        Cree, active y supervise encuestas detalladas para recolectar datos valiosos sobre el
                                        desempeño profesional de nuestros egresados.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Reportes y Estadísticas --}}
                        <div class="w-full">
                            <div
                                class="card h-full flex flex-col overflow-hidden animate-slide-in-right delay-200 border border-primary-lightest">
                                {{-- Aplicado .card, Borde sutil añadido --}}
                                <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80"
                                    class="w-full h-52 object-cover rounded-t-2xl" alt="Reportes y Estadísticas">
                                <div class="p-7 flex flex-col flex-grow">
                                    <h5 class="text-text-primary font-headings font-bold text-2xl mb-4"><i
                                            class="bi bi-bar-chart-line-fill mr-3 text-secondary"></i>Reportes y Estadísticas
                                    </h5> {{-- Aplicado text-text-primary --}}
                                    <p class="text-text-light font-body text-base flex-grow leading-relaxed">
                                        {{-- Aplicado font-body --}}
                                        Genere indicadores clave y reportes dinámicos para apoyar decisiones basadas en datos
                                        reales y actualizados, mejorando la oferta académica.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('graduate'))
                    <h1
                        class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">
                        Bienvenido, Egresado</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16 justify-items-center">

                        {{-- Tarjeta de Actualización de Perfil --}}
                        <div class="w-full">
                            <div
                                class="card h-full flex flex-col overflow-hidden animate-slide-in-left border border-primary-lightest">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80"
                                    class="w-full h-64 object-cover rounded-t-2xl" alt="Perfil Profesional">
                                <div class="p-7 flex flex-col flex-grow">
                                    <h5 class="text-text-primary font-headings font-bold text-2xl mb-4">
                                        <i class="bi bi-person-badge-fill mr-3 text-secondary"></i>
                                        Actualización de Perfil
                                    </h5>
                                    <p class="text-text-light font-body text-base flex-grow leading-relaxed">
                                        Mantenga su información actualizada: empresa, cargo, salario y habilidades técnicas que
                                        reflejan su valiosa trayectoria laboral.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Participación en Encuestas --}}
                        <div class="w-full">
                            <div
                                class="card h-full flex flex-col overflow-hidden animate-slide-in-right delay-100 border border-primary-lightest">
                                <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=800&q=80"
                                    class="w-full h-64 object-cover rounded-t-2xl" alt="Encuestas">
                                <div class="p-7 flex flex-col flex-grow">
                                    <h5 class="text-text-primary font-headings font-bold text-2xl mb-4">
                                        <i class="bi bi-clipboard-check-fill mr-3 text-secondary"></i>
                                        Participación en Encuestas
                                    </h5>
                                    <p class="text-text-light font-body text-base flex-grow leading-relaxed">
                                        Su participación es crucial para la mejora continua de la formación y la relevancia del
                                        programa académico que lo vio crecer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('employer'))
                    <h1
                        class="text-center mb-12 text-primary font-headings text-4xl lg:text-5xl font-extrabold animate-fade-in-down">
                        Bienvenido, Empleador</h1>


                    <div
                        class="card max-w-4xl mx-auto mb-16 flex flex-col overflow-hidden animate-fade-in border border-primary-lightest">
                        {{-- Aplicado .card, Borde sutil añadido --}}
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1200&q=80"
                            class="w-full h-80 object-cover rounded-t-2xl" alt="Estadísticas Laborales">
                        <div class="p-8 flex flex-col flex-grow">
                            <h5 class="text-text-primary font-headings font-bold text-3xl text-center mb-5"><i
                                    class="bi bi-graph-up-arrow mr-3 text-secondary"></i>Buscar talento</h5>
                            {{-- Aplicado text-text-primary --}}
                            <p class="text-xl text-text-light text-center font-body flex-grow leading-relaxed">
                                {{-- Aplicado font-body --}}
                                Acceda a un buscador de egresados de la carrera de Desarrollo de Software del Instituto Sucre.
                                Esta herramienta fortalece la articulación entre el Instituto y el sector productivo,
                                facilitando procesos de reclutamiento, alianzas estratégicas y toma de decisiones basada en
                                datos reales.
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-center text-error text-xl mt-12 font-semibold font-body animate-fade-in">
                        {{-- Aplicado text-error, font-body --}}
                        Su rol no está reconocido en el sistema. Por favor, contacte al administrador para resolver esta
                        situación.
                    </p>
                @endif
            </section>
        @else
            <p class="text-center text-xl mt-12 text-text-light font-body animate-fade-in"> {{-- Aplicado font-body --}}
                Para acceder al sistema y descubrir sus funcionalidades, por favor, inicie sesión con sus credenciales.
            </p>
        @endauth

        <div class="border-t-2 border-gray-200 my-16 w-2/3 mx-auto"></div> {{-- Ajuste: Separador más grueso y sutil --}}

        {{-- Presentación general del proyecto --}}
        <div class="text-center mb-16 pt-8">
            <h1 class="font-bold text-primary font-headings text-4xl lg:text-6xl mb-4 animate-fade-in-down">
                <i class="t"></i>Sistema de Seguimiento Profesional de Egresados
                {{-- Ajuste: Cambiado text-yellow-accent a text-accent --}}
            </h1>
            <p class="text-xl lg:text-2xl text-text-secondary font-body mt-4 max-w-4xl mx-auto animate-fade-in delay-200">
                Una solución integral para potenciar el futuro profesional del Instituto Superior Universitario Tecnológico
                Sucre.</p> {{-- Aplicado font-body --}}
            <hr class="w-24 border-t-4 border-secondary mx-auto my-8 opacity-100">
        </div>

        {{-- Descripción general --}}
        <section class="mb-20 px-6 max-w-5xl mx-auto"> {{-- Ajuste: Mayor margen inferior y ancho máximo --}}
            <h2 class="mb-10 text-primary font-headings font-bold text-4xl text-center animate-fade-in-left">
                {{-- Ajuste: Mayor margen inferior --}}
                <i class=""></i>¿Qué es? {{-- Ajuste: Cambiado text-yellow-accent a text-accent --}}
            </h2>
            <p class="text-xl max-w-3xl mx-auto text-text-light font-body text-center mb-10 animate-fade-in delay-300">
                {{-- Aplicado font-body --}}
                Esta aplicación web profesional, innovadora y robusta, permitirá al Instituto Superior Universitario
                Tecnológico Sucre:
            </p>

            <ul class="list-none mb-10 max-w-4xl mx-auto space-y-6 mt-8"> {{-- Ajuste: Ancho máximo ajustado --}}
                <li
                    class="flex items-start py-4 card px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-400 border border-gray-100">
                    {{-- Aplicado .card --}}
                    <i class=""></i>
                    <span class="text-text-light font-body text-lg leading-relaxed">Registrar, centralizar y gestionar de
                        manera eficiente la información profesional detallada de sus egresados de la carrera de Desarrollo
                        de Software.</span> {{-- Aplicado font-body --}}
                </li>
                <li
                    class="flex items-start py-4 card px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-500 border border-gray-100">
                    {{-- Aplicado .card --}}
                    <i class=""></i>
                    <span class="text-text-light font-body text-lg leading-relaxed">Recolectar y analizar datos exhaustivos
                        sobre el empleo actual, habilidades adquiridas, sector laboral y ubicación geográfica de sus
                        graduados, obteniendo una visión completa.</span> {{-- Aplicado font-body --}}
                </li>
                <li
                    class="flex items-start py-4 card px-6 hover:shadow-lg transform hover:scale-105 transition-all duration-300 animate-slide-in-right delay-600 border border-gray-100">
                    {{-- Aplicado .card --}}
                    <i class=""></i>
                    <span class="text-text-light font-body text-lg leading-relaxed">Generar reportes e indicadores clave de
                        desempeño laboral y empleabilidad, proporcionando información valiosa para apoyar decisiones
                        académicas e institucionales estratégicas.</span> {{-- Aplicado font-body --}}
                </li>
                <li
                    class="flex items-start py-4 card px-6 hover:shadow-lg transform hover:-translate-y-3 transition-all duration-300 animate-slide-in-right delay-700 border border-gray-100">
                    {{-- Aplicado .card --}}
                    <i class=""></i>
                    <span class="text-text-light font-body text-lg leading-relaxed">Facilitar una comunicación fluida y
                        eficiente con los egresados mediante mensajes internos y notificaciones personalizadas,
                        fortaleciendo el vínculo de la comunidad Sucre.</span> {{-- Aplicado font-body --}}
                </li>
                <li
                    class="flex items-start py-4 card px-6 hover:shadow-lg transform hover:-translate-y-3 transition-all duration-300 animate-slide-in-right delay-800 border border-gray-100">
                    {{-- Aplicado .card --}}
                    <i class=""></i>
                    <span class="text-text-light font-body text-lg leading-relaxed">Garantizar la máxima confidencialidad y
                        seguridad de todos los datos personales y laborales, aplicando las mejores prácticas en protección
                        de la información.</span> {{-- Aplicado font-body --}}
                </li>
            </ul>
        </section>
    </div>
    </section>
@endsection
