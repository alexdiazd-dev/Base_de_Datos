
document.addEventListener("click", function(e) {
    const btn = e.target.closest(".btn-ver-detalle");
    if (!btn) return;

    const modal = new bootstrap.Modal(document.getElementById("modalDetalleProducto"));

    // Insertar datos
    document.getElementById("mdp_titulo").textContent = btn.dataset.nombre;
    document.getElementById("mdp_precio").textContent = parseFloat(btn.dataset.precio).toFixed(2);
    document.getElementById("mdp_descripcion").textContent = btn.dataset.descripcion;
    document.getElementById("mdp_categoria").textContent = btn.dataset.categoria;

    // Imagen
    let img = btn.dataset.imagen;
    document.getElementById("mdp_imagen").src = img.startsWith("http")
        ? img
        : `${window.location.origin}/storage/${img}`;

    // Etiquetas
    const cont = document.getElementById("mdp_etiquetas");
    cont.innerHTML = "";

    if (btn.dataset.etiquetas) {
        let tags = btn.dataset.etiquetas.split(",");
        tags.forEach(t => {
            let s = document.createElement("span");
            s.className = "badge rounded-pill px-3 py-2";
            s.style.background = "#eee";
            s.style.color = "#4b3c3a";
            s.textContent = t.trim();
            cont.appendChild(s);
        });
    }

    // Acción agregar al carrito
    document.getElementById("mdp_btnAgregar").onclick = function() {
        const trigger = document.querySelector(`.btn-agregar-carrito[data-id="${btn.dataset.id}"]`);
        if (trigger) trigger.click();
        modal.hide();
    };

    modal.show();
});

