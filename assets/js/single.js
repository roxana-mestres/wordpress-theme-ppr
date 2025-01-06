document.addEventListener("DOMContentLoaded", function () {
  function limpiarLineaInicial(bloque) {
    if (!bloque || !bloque.firstChild) return;

    for (let i = 0; i < 2; i++) {
      if (
        bloque.firstChild &&
        bloque.firstChild.nodeName === "P" &&
        bloque.firstChild.textContent.trim() === ""
      ) {
        bloque.removeChild(bloque.firstChild);
      } else if (bloque.firstChild && bloque.firstChild.nodeName === "BR") {
        bloque.removeChild(bloque.firstChild);
      } else {
        break;
      }
    }
  }

  const contenido = document.querySelector(".js-columnas-dinamicas");
  if (!contenido) return;

  function procesarNodo(node) {
    if (node.nodeType === Node.TEXT_NODE) {
      const texto = node.textContent.trim();
      return texto !== "" ? texto : "";
    } else if (node.nodeName === "BR") {
      return "<br>";
    } else if (node.nodeName === "P") {
      const contenidoP = Array.from(node.childNodes).map(procesarNodo).join("");
      return `<p>${contenidoP}</p>`;
    } else if (node.nodeType === Node.ELEMENT_NODE) {
      return Array.from(node.childNodes).map(procesarNodo).join("");
    }
    return "";
  }

  const textoCompleto = Array.from(contenido.childNodes)
    .map(procesarNodo)
    .join("")
    .replace(/style="[^"]*"/g, "")
    .replace(/class="[^"]*"/g, "")
    .trim();

  const totalPalabras = textoCompleto
    .split(/\s+/)
    .filter((palabra) => palabra !== "").length;

  if (totalPalabras <= 250) {
    const imagenDestacada = document.querySelector(".imagen-destacada img");
    const entradaContenido = document.querySelector(".entrada-contenido");
    if (imagenDestacada) {
      imagenDestacada.style.maxWidth = "90%";
      entradaContenido.style.maxWidth = "80%";
    }
  }

  if (totalPalabras <= 250) {
    contenido.innerHTML = textoCompleto;
    return;
  }

  const oraciones = textoCompleto.split(/(?<=\.)/);

  contenido.innerHTML = "";

  let currentBlock = document.createElement("div");
  currentBlock.classList.add("bloque-uno");

  let blockCounter = 0;
  let filaColumnas = null;
  let wordCount = 0;

  oraciones.forEach((oracion) => {
    const palabrasEnOracion = oracion
      .split(/\s+/)
      .filter((palabra) => palabra !== "").length;

    wordCount += palabrasEnOracion;

    currentBlock.innerHTML += oracion;

    const wordLimit = 100;

    if (wordCount >= wordLimit && oracion.endsWith(".")) {
      if (blockCounter === 0) {
        const imgBlock = document.createElement("div");
        imgBlock.classList.add("img-bloque");
        const imagenDestacada = document.querySelector(".imagen-destacada");
        imgBlock.appendChild(imagenDestacada);
        imgBlock.appendChild(currentBlock);
        contenido.appendChild(imgBlock);
      } else {
        if (blockCounter % 2 === 0) {
          filaColumnas = document.createElement("div");
          filaColumnas.classList.add("fila-columnas");
          contenido.appendChild(filaColumnas);
        }

        if (filaColumnas && currentBlock.innerHTML.trim() !== "") {
          currentBlock.classList.add("columna");
          limpiarLineaInicial(currentBlock);
          filaColumnas.appendChild(currentBlock);
        }
      }

      if (blockCounter % 2 === 1) {
        const separador = document.createElement("div");
        separador.classList.add("separador");
        separador.innerHTML = `<img src="${contenido.dataset.template}/assets/images/separador.svg" alt="Separador">`;
        contenido.appendChild(separador);
      }

      currentBlock = document.createElement("div");
      currentBlock.classList.add("bloque-texto");
      wordCount = 0;
      blockCounter++;
    }
  });

  if (filaColumnas && filaColumnas.childElementCount > 2) {
    const nuevaFila = document.createElement("div");
    nuevaFila.classList.add("fila-columnas");

    const ultimaColumna = filaColumnas.lastElementChild;
    nuevaFila.appendChild(ultimaColumna);

    contenido.appendChild(nuevaFila);
  }
});
