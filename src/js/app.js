
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
const cita = {
    id: "",
    nombre: "",
    fecha: "",
    hora: "",
    servicios: []
};

document.addEventListener("DOMContentLoaded",
    function(){
        iniciarApp();
    }
)

function iniciarApp(){
    mostrarSeccion();//Muestra y oculta las secciones
    tabs(); //cambia la seccion de citas
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaSiguiente(); //pasar a la siguiente pagina con el paginar
    paginaAnterior(); //pasar a la pagina anterior con el paginar

    consultarAPI(); //Consulta la API en el backend de php
    nombreCliente(); //agrega el nombre del cliente a la cita
    idcliente(); //agrega el id del cliente a la cita
    seleccionarFecha(); //seleccionar la hora de la cita
    seleccionarHora(); //seleccionar la hora de la cita
    mostrarResumen(); //muestra el resumen de la cita
}

function mostrarSeccion(){
    //Ocultar si tiene el mostrar
    const seccionAnterior = document.querySelector(".mostrar");
    if(seccionAnterior){
    seccionAnterior.classList.remove("mostrar");
     }

    //seleccionar la seccion
    const seccion = document.querySelector(`#paso-${paso}`); 
    seccion.classList.add("mostrar");

    //eliminar el resaltado
    //Resaltar seccion actual
    const tabAnterior = document.querySelector(".actual");
    if(tabAnterior){
       tabAnterior.classList.remove("actual"); 
    } 

    //Resaltar seccion actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");
}

function tabs(){
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach(boton => {
        boton.addEventListener("click", function(e){
          paso = parseInt(e.target.dataset.paso); 
           botonesPaginador();
          mostrarSeccion();

          if(paso === 3){
            mostrarResumen();
          }
        });   
    })
}

function botonesPaginador(){
    const anterior = document.querySelector("#anterior");
    const siguiente = document.querySelector("#siguiente");

    if(paso === 1){
        anterior.classList.add("ocultar");
    }else if(paso === 3){
        anterior.classList.remove("ocultar");
        siguiente.classList.add("ocultar"); 
        mostrarResumen();
    }else{
        anterior.classList.remove("ocultar");
        siguiente.classList.remove("ocultar");
    }
     mostrarSeccion(); 
}

function paginaAnterior(){
   const paginaAnterior = document.querySelector("#anterior");
   paginaAnterior.addEventListener("click", function(){
    if(paso <= pasoInicial) return; 
        paso--;
      botonesPaginador();
   })
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector("#siguiente");
     paginaSiguiente.addEventListener("click", function(){
    if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    }) 
}

async function consultarAPI(){
    try{
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio; //aplicando destroyer

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${precio}`;
    
        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idservicio = id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector("#servicios").appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    

    const divServicio = document.querySelector(`[data-idservicio="${id}"]`); 

    //comprobar si un servicio esta seleccionado
    if(servicios.some(agregado => agregado.id === id)){
        //eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove("seleccionado");
    }else{
        //agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
}

function nombreCliente(){
    const nombre = document.querySelector("#nombre").value;
    cita.nombre = nombre;
     
}

function idcliente(){
    const id = document.querySelector("#id").value;
    cita.id = id;
}

function seleccionarFecha(){
   
    const inputfecha = document.querySelector("#fecha");
    inputfecha.addEventListener("input", function(e){
        const dia = new Date(e.target.value).getUTCDay();

        if([1].includes(dia)){
            e.target.value = "";
            mostrarAlerta("no abrimos los lunes", "error", ".formulario");
        }else{
          cita.fecha = e.target.value;  
        } 
        
    }); 
  }  

function seleccionarHora(){
   const inputhora = document.querySelector("#hora");
   inputhora.addEventListener("input", function(e){

    const horacita = e.target.value;
    const hora = horacita.split(":")[0];

    if(hora < 10 || hora >= 23){
         e.target.value = "";
            mostrarAlerta("no trabajamos en ese horario", "error", ".formulario");
    }else{
         cita.hora = e.target.value; 
         console.log(cita);
    }
   });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){
    //previene crear mas de una alerta
     const alertaprevia = document.querySelector(".alerta"); 
    if(alertaprevia){
        alertaprevia.remove();
    }

    //creamos la alerta
    const alerta = document.createElement("DIV");
    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta); 

    //eliminar alerta
    if(desaparece){
    setTimeout(() =>{
        alerta.remove();
    }, 3000);
   }
}

function mostrarResumen(){
    const resumen = document.querySelector(".contenedor-resumen");

    //Limpiar el contenido del resumen 

    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes("") || cita.servicios.length === 0){
        mostrarAlerta("Faltan datos de servicios, hora o fecha", "error", ".contenedor-resumen", false);
 
        return;
    }

    //Formatear el div de resumen
    const { nombre, fecha, hora, servicios} = cita;

    //Heading para servicios en resumen
    const heading = document.createElement("H3");
    heading.textContent = "Resumen de Servicios"; 
    resumen.appendChild(heading);
    
    //Iterando los servicios
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");

        const textoServicio = document.createElement("P");
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

    });      

    //Heading para cita en resumen
    const headingcita = document.createElement("H3");
    headingcita.textContent = "Resumen de Cita"; 
    resumen.appendChild(headingcita);

    const nombrecliente = document.createElement("P");
    nombrecliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Formatear la fecha en español 
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const opciones = {weekday: "long", year: "numeric", month: "long", day: "numeric"};
    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const fechaFormateada = fechaUTC.toLocaleDateString("es-ES", opciones);

    const fechacita = document.createElement("P");
    fechacita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horacita = document.createElement("P");
    horacita.innerHTML = `<span>Hora:</span> ${hora}`;

    //Boton para crear cita
    const boton = document.createElement("BUTTON");
    boton.classList.add("boton");
    boton.textContent = "Reservar Cita";
    boton.onclick = reservarCita;

    resumen.appendChild(nombrecliente); 
    resumen.appendChild(fechacita);
    resumen.appendChild(horacita);
    resumen.appendChild(boton);
 
}

async function reservarCita(){
    const { id, fecha, hora, servicios } = cita;
    const idservicio = servicios.map(servicio => servicio.id); //map busca las coincidencias y la agrega a la variable mientras que foreach solo itera

     const datos = new FormData();
     datos.append("usuarioId", id);
     datos.append("fecha", fecha);
     datos.append("hora", hora);
     datos.append("servicios", idservicio);

     //Peticion hacia la api
     try{
     const url = `${location.origin}/api/citas`;
     const respuesta = await fetch(url, {
        method: "POST",
        body: datos
     });
     const resultado = await respuesta.json();

     if(resultado.resultado){ 
       Swal.fire({
       title: "Cita Creada",
    text: "Cita creada correctamente",
    button: "OK"
      }).then(() => {
        setTimeout(() =>{
        window.location.reload();
    }, 2000);
    });
    }
  }catch(error){
     Swal.fire({ 
   title: "Oops...",
   text: "Hubo un error al guardar la cita" 
   });
  }

    //  console.log([...datos]); para testear que se este pasando todo
}