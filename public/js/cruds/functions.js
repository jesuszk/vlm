const functions = new (function () {
  const container__fields = document.getElementById("container__fields");

  this.onchange_select_tag = function (selectElement) {
    const selectValue = selectElement.value;
    const elements_to_showing_for_numbers = document.querySelectorAll(
      ".hidden-for-different-select"
    );

    if (selectValue.includes("select")) {
      elements_to_showing_for_numbers.forEach((elm) => {
        elm.classList.add("d-none");
      });
    } else {
      elements_to_showing_for_numbers.forEach((elm) => {
        elm.classList.remove("d-none");
      });
    }
  };

  /**
   * Esconde os campos step, mínimo e máximo se for texto,
   * mas se for números, os campos aparecem.
   * Se for texto, o campo tamanho será exibido,
   * caso não seja, será escondido.
   * @param {HTMLElement} selectElement
   */
  this.onchange_select_type = (selectElement) => {
    const selectValue = selectElement.value;
    const elements_to_showing_for_numbers = document.querySelectorAll(
      ".showing-for-numbers"
    );

    const elements_to_hidden_for_numbers = document.querySelectorAll(
      ".hidden-for-numbers"
    );

    if (selectValue.includes("number")) {
      elements_to_showing_for_numbers.forEach((elm) => {
        elm.classList.remove("d-none");
      });

      elements_to_hidden_for_numbers.forEach((elm) => {
        elm.classList.add("d-none");
      });
    } else {
      elements_to_showing_for_numbers.forEach((elm) => {
        elm.classList.add("d-none");
      });
      elements_to_hidden_for_numbers.forEach((elm) => {
        elm.classList.remove("d-none");
      });
    }
  };

  /**
   * Função genérica
   * Pega elemento parente de acordo com o level informado
   * @param {HTMLElementEventMap} element
   * @param {int} levels
   * @returns HTMLElement
   */
  this.get_parent_element = function getParent(element, levels) {
    let currentElement = element;

    for (let i = 0; i < levels; i++) {
      if (!currentElement.parentElement) {
        return null;
      }
      currentElement = currentElement.parentElement;
    }

    return currentElement;
  };
})();
