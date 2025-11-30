// let panelActual = null; // Para cerrar el detalle anterior

// function mostrarDetallePedido(pedido, boton) {

//     console.log('DATA RECIBIDA:', pedido);

//     // 1. Cerrar panel previo
//     if (panelActual) {
//         panelActual.remove();
//         panelActual = null;
//     }

//     // 2. Obtener template inline
//     const template = document.querySelector("#template-panel-inline").innerHTML;

//     // 3. Insertar debajo del card correspondiente
//     const wrapper = document.createElement("div");
//     wrapper.innerHTML = template;

//     const card = boton.closest('.pedido-card');
//     card.insertAdjacentElement("afterend", wrapper);

//     panelActual = wrapper;

//     // ================================
//     // 4. ASIGNAR DATOS (delivery)
//     // ================================

//     const envio = pedido.envio ?? {};

//     wrapper.querySelector("#in-id").textContent = pedido.id_pedido ?? "—";
//     wrapper.querySelector("#in-nombre").textContent = 
//         (envio.nombres ?? "—") + " " + (envio.apellidos ?? "");
    
//     wrapper.querySelector("#in-telefono").textContent = envio.telefono ?? "—";
//     wrapper.querySelector("#in-documento").textContent = envio.documento ?? "—"; // si no lo tienes, queda —
//     wrapper.querySelector("#in-vivienda").textContent = envio.tipo_vivienda ?? "—";
//     wrapper.querySelector("#in-direccion").textContent = envio.direccion ?? "—";
//     wrapper.querySelector("#in-referencia").textContent = envio.referencia ?? "—";
//     wrapper.querySelector("#in-ubicacion").textContent = envio.ciudad ?? "—";

//     // ================================
//     // 5. ESTADO + MÉTODO DE PAGO
//     // ================================
//     wrapper.querySelector("#in-estado").textContent = pedido.estado ?? "—";
//     wrapper.querySelector("#in-metodo").textContent = envio.metodo_pago ?? "—";

//     // ================================
//     // 6. PRODUCTOS
//     // ================================
//     const productosDiv = wrapper.querySelector("#in-productos");
//     productosDiv.innerHTML = ""; // limpio

//     if (pedido.detalles && pedido.detalles.length > 0) {
//         pedido.detalles.forEach(det => {

//             const prodHTML = `
//                 <div class="d-flex justify-content-between p-2 mb-2 rounded-3" style="background:#fdf8ff;">
//                     <div>
//                         <strong>${det.producto?.nombre ?? "Producto"}</strong>
//                         <br>
//                         <small class="text-muted">
//                             ${det.cantidad} x S/ ${Number(det.producto?.precio ?? 0).toFixed(2)}
//                         </small>
//                     </div>
//                     <strong class="text-brown">
//                         S/ ${Number(det.subtotal).toFixed(2)}
//                     </strong>
//                 </div>
//             `;
//             productosDiv.insertAdjacentHTML("beforeend", prodHTML);

//         });
//     } else {
//         productosDiv.innerHTML = `<small class="text-muted">Sin productos</small>`;
//     }

//     // ================================
//     // 7. TOTALES
//     // ================================
//     wrapper.querySelector("#in-subtotal").textContent =
//         "S/ " + Number(pedido.total ?? 0).toFixed(2);

//     wrapper.querySelector("#in-envio").textContent =
//         envio.costo_envio ? ("S/ " + Number(envio.costo_envio).toFixed(2)) : "S/ 0.00";

//     wrapper.querySelector("#in-total").textContent =
//         "S/ " + (Number(pedido.total ?? 0) + Number(envio.costo_envio ?? 0)).toFixed(2);

//     // ================================
//     // 8. NOTAS
//     // ================================
//     if (envio.notas && envio.notas.trim() !== "") {
//         wrapper.querySelector("#in-notas").textContent = envio.notas;
//         wrapper.querySelector("#in-notas-container").classList.remove("d-none");
//     }

//     // ================================
//     // 9. FUNCIONALIDAD BOTÓN CERRAR
//     // ================================
//     wrapper.querySelector(".btn-close")?.addEventListener("click", () => {
//         wrapper.remove();
//         panelActual = null;
//     });
// }
