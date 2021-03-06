<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--== CSS BOOTSTRAP ==-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!--=========== UNICONS ============-->
    <!--link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>

<body>
    <div class="container">
        <div class="row border border-primary rounded mt-5 mb-2 p-2 text-justify" id="descripcion__ejercicio">
            <h2 class="titulo">Descripcion__ejercicio</h2>
        Construccion de una lista con tramos horarios, en intervalos de 30 min. Empieza a las 8 am y termina a las 8pm (o sea un cuadro con un bloque que empiece a las 8, luego 8.30, 9, 9 30.. así hasta las 8pm)
        La empresa tiene una disponibilidad de 8 motociclistas cada 30 min.
        Cuando alguien haga click sobre una de estas cajitas debería tomar un recurso de motociclista
        (O sea un contador que empiece en 8 y luego baje a 7, a demás de marcar la caja en rojo cuando se ocupe)
        Si el mismo usuario da click en la misma caja, debe liberar el recurso, si se encontraba en rojo, debe liberar el recurso, o sea el contador nuevamente pasa de 7 a 8
        Si otros usuarios han tomado a todos los motociclistas, la caja debe aparecer en color amarillo y no me debe dejar tomar ese horario
        </div>
        <div class="row">
            <div class="col-7 list-group" id="tramosHorarios">
                <div class="input-group border border-secondary m-1 p-1 rounded" id="cabecera">
                    <div class="col text-center">Horario</div>
                    <div class="col text-center">Motociclistas</div>
                    <div class="col text-center">Estado</div>
                </div>
            </div>
            <div class="col-5 border p-2 my-1" id="clientes">
                <h3 class="col-12 titulo">Clientes</h3>
                <div class="btn-group-vertical p-1 px-2" id="clientes__container">
                </div>
            </div>
        </div>
    </div>
    <script>
        let motociclistas = 8;
        let usuarios = ['Maria', 'Pedro', 'Luis', 'Carlos', 'Josefina', 'Laura', 'Israel', 'Joel','Extra'];
        let arrayTramos = [];
        let ocupacionesPorUsuario = [];
        let usuarioActual = 0;
        let cabecera = document.getElementById('cabecera');
        const hora__inicio = new Date("2018/01/30 08:00:00"); //"8:00 a.m.";
        const hora__final = new Date("2018/01/30 20:00:00"); //"8:00 p.m.";

        function getTamanioTramos(hora__I, hora__F) {
            let contador = 0;
            let seguir = true;
            do {
                contador++;
                hora__I.setMinutes(hora__I.getMinutes() + 30);
                if (hora__I.getTime() >= hora__F.getTime()) {
                    seguir = false;
                }
            }
            while (seguir)
            return ++contador;
        }

        function arregloInicial() {
            let tamanioTramos = getTamanioTramos(new Date(hora__inicio.toISOString()), new Date(hora__final.toISOString()));

            for (let i = 0; i < tamanioTramos; i++) {
                let tramo__horario = {
                    id: i,
                    motos: 8,
                    estado: "Disponible"
                };
                arrayTramos.push(tramo__horario);
            }
            console.log('arrayTramos', arrayTramos);
        }

        //asignar formato de Hora
        function getHorario(hora) {
            let horas = hora.getHours();
            let minutos = hora.getMinutes();
            if (hora.getHours() < 10)
                horas = "0" + horas;
            let mayor = false;
            if (hora.getHours() > 12) {
                horas = hora.getHours() - 12;
                mayor = true;
            }

            if (hora.getMinutes() < 10)
                minutos = "0" + minutos;
            let stringHora = horas + ":" + minutos;
            if (mayor)
                stringHora = stringHora + " p.m.";
            else
                stringHora = stringHora + " a.m.";
            return stringHora;

        }

        function getTramoHorario(hora, motos, estado, valor) {
            let tramo__horario = document.createElement("div");
            tramo__horario.classList.add('btn');
            tramo__horario.classList.add('btn__tramo__horario');
            tramo__horario.classList.add('btn-outline-success');
            tramo__horario.classList.add('input-group');
            tramo__horario.classList.add('m-1');
            tramo__horario.setAttribute('value', valor);
            //tramo__horario.classList.add('list-group-item-action');
            let horario = document.createElement("div");
            horario.classList.add('col-12');
            horario.classList.add('col-xl-4');
            horario.textContent = getHorario(hora);
            let contador = document.createElement("div");
            contador.classList.add('col');
            contador.classList.add('col-xl-4');
            contador.classList.add('col__contador');
            //contador.setAttribute('value',valor);
            //contador.textContent = motociclistas;
            contador.textContent = motos;
            let disponible = document.createElement("div");
            disponible.classList.add('col');
            disponible.classList.add('col__estado');
            disponible.id = "estado";
            //disponible.textContent = "Disponible";
            disponible.textContent = estado;
            tramo__horario.appendChild(horario);
            tramo__horario.appendChild(contador);
            tramo__horario.appendChild(disponible);
            return tramo__horario;
        }

        function generarTramosHorarios(arrayTramos_h) {
            let listaTramos = document.getElementById('tramosHorarios');
            listaTramos.innerHTML = "";
            listaTramos.appendChild(cabecera);
            var hora__aux = new Date(hora__inicio.toISOString()); //Date("2018/01/30 08:00:00");
            //console.log('hora', hora__aux);
            //console.log('hora_inicio', hora__inicio);
            let contador = 0;
            let seguir = true;

            do {
                //let tramo__horario = getTramoHorario(hora__aux);
                let tramo__horario = getTramoHorario(hora__aux, arrayTramos_h[contador].motos, arrayTramos_h[contador].estado, contador);

                tramo__horario.classList.add('tramo__horario' + contador);

                listaTramos.appendChild(tramo__horario);
                contador++;
                hora__aux.setMinutes(hora__aux.getMinutes() + 30);
                if (hora__aux.getTime() >= hora__final.getTime()) {
                    //let tramo__horario1 = getTramoHorario(hora__aux);
                    let tramo__horario1 = getTramoHorario(hora__aux, arrayTramos_h[contador].motos, arrayTramos_h[contador].estado, contador);
                    tramo__horario1.classList.add('tramo__horario' + contador);
                    listaTramos.appendChild(tramo__horario1);
                    seguir = false;
                }
            }
            while (seguir)
        }

        function ocuparTramoCliente(idUsuario, idTramo) {
            let ocupacion = {
                idUsuario: idUsuario,
                idTramo: idTramo
            };

            ocupacionesPorUsuario.push(ocupacion);
        }

        function funcionesBotones() {
            let botones = document.querySelectorAll('.btn__tramo__horario');
            botones.forEach(btn => {
                btn.addEventListener('click', () => {
                    let estado = btn.querySelectorAll('.col__estado');
                    let contador = btn.querySelectorAll('.col__contador');
                    let numeroMotos = 0;
                    contador.forEach(etiqueta => {
                        numeroMotos = parseInt(etiqueta.textContent);
                    })
                    if (btn.classList.contains('btn-outline-success')) {
                        //console.log('contienes success');
                        btn.classList.remove('btn-outline-success');
                        btn.classList.add('btn-outline-danger');
                        //console.log('boton', btn);
                        estado.forEach(etiqueta => {
                            etiqueta.textContent = 'Ocupado';
                            //arrayTramos[btn.getAttribute('value')].estado = 'Ocupado';
                            ocuparTramoCliente(parseInt(usuarioActual), parseInt(btn.getAttribute('value')));
                            console.log('ocupacionesPorUsuario', ocupacionesPorUsuario);
                        });
                        contador.forEach(etiqueta => {
                            let numero = parseInt(etiqueta.textContent);

                            etiqueta.textContent = --numero;

                            console.log('btnValor', btn.getAttribute('value'));

                            //arrayTramos[btn.getAttribute('value')].motos = numero;
                            //arrayTramos. [0].motos = numero;
                            console.log('arrayTramos', arrayTramos);
                            console.log('contador', etiqueta.textContent)
                        });

                    } else if (btn.classList.contains('btn-outline-danger')){
                        btn.classList.add('btn-outline-success');
                        btn.classList.remove('btn-outline-danger');
                        estado.forEach(etiqueta => {
                            etiqueta.textContent = 'Disponible';
                            //arrayTramos[btn.getAttribute('value')].estado = 'Disponible';
                            let desocupar0 = ocupacionesPorUsuario.filter(ocupacion => ocupacion.idTramo == btn.getAttribute('value'));
                            let desocupar1 = desocupar0.find(ocupacion => ocupacion.idUsuario == usuarioActual);
                            let indice = ocupacionesPorUsuario.indexOf(desocupar1);
                            console.log('desocupado', desocupar1);
                            console.log('indice', indice);
                            ocupacionesPorUsuario.splice(indice, 1);
                            console.log('ocupacionesPorUsuario', ocupacionesPorUsuario);
                        });
                        contador.forEach(etiqueta => {
                            let numero = parseInt(etiqueta.textContent);
                            etiqueta.textContent = ++numero;

                            //arrayTramos[btn.getAttribute('value')].motos = numero;
                            console.log('contador', etiqueta.textContent)
                        });
                    }

                })
            })
        }

        function agregarClientes(clientes) {
            let contenedor = document.getElementById('clientes__container');
            for (let i in clientes) {
                let cliente = document.createElement("button");
                cliente.classList.add('btn');
                if (i == 0) {
                    cliente.classList.add('btn-success');
                } else {
                    cliente.classList.add('btn-primary');
                }

                cliente.classList.add('m-1');
                cliente.classList.add('cliente');
                cliente.textContent = clientes[i];
                cliente.setAttribute('value', i);
                contenedor.appendChild(cliente);

            }
        }

        function actualizarOcupacionesUsuario(idCliente) {
            let botones = document.querySelectorAll('.btn__tramo__horario');

            ocupacionesPorUsuario.forEach(ocupacion => {
                botones.forEach(btn => {
                    if (ocupacion.idTramo == btn.getAttribute('value')) {
                        let contador = btn.querySelectorAll('.col__contador');
                        let numero = 0;
                        contador.forEach(etiqueta => {
                            numero = parseInt(etiqueta.textContent);
                            etiqueta.textContent = --numero;
                        });
                    }
                })

                if (ocupacion.idUsuario == idCliente) {
                    //console.log('ocupa un lugar');
                    //return;
                    botones.forEach(btn => {
                        if (btn.getAttribute('value') == ocupacion.idTramo) {
                            let estado = btn.querySelectorAll('.col__estado');
                            btn.classList.remove('btn-outline-success');
                            btn.classList.add('btn-outline-danger');
                            estado.forEach(etiqueta => {
                                etiqueta.textContent = 'Ocupado';
                            });
                            //let contador = btn.querySelectorAll('.col__contador');
                        }
                    })
                }
            })
            botones.forEach(btn => {
                let contador = btn.querySelectorAll('.col__contador');
                let numero = 0;
                contador.forEach(etiqueta => {
                    numero = parseInt(etiqueta.textContent);
                });
                if (numero == 0 && btn.classList.contains('btn-outline-success')) {
                    btn.classList.remove('btn-outline-success');
                    //btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-outline-warning');
                    let estado = btn.querySelectorAll('.col__estado');
                    estado.forEach(etiqueta => {
                        etiqueta.textContent = 'Sin servicio';
                    })
                }
            })
        }

        function funcionesBotonesClientes() {
            let clientes = document.querySelectorAll('.cliente');
            clientes.forEach(cliente => {
                cliente.addEventListener('click', () => {
                    clientes.forEach(cliente_aux => {
                        cliente_aux.classList.remove('btn-success')
                        cliente_aux.classList.add('btn-primary')
                    })
                    cliente.classList.remove('btn-primary')
                    cliente.classList.add('btn-success')
                    usuarioActual = parseInt(cliente.getAttribute('value'));
                    console.log('idUsuarioActual', usuarioActual);
                    generarTramosHorarios(arrayTramos);
                    actualizarOcupacionesUsuario(usuarioActual);
                    funcionesBotones();

                })
            })
        }
        arregloInicial();
        generarTramosHorarios(arrayTramos);
        funcionesBotones();
        agregarClientes(usuarios);
        funcionesBotonesClientes();
    </script>
</body>

</html>