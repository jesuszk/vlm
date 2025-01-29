const repeat = new (function () {
  const container__fields = document.getElementById("container__fields");

  this.add_field = function () {
    let idx = this.get_next_idx();
    container__fields.insertAdjacentHTML(
      "beforeEnd",
      `<div class="row mb-3" data-idx="${idx}">
            <div class="col-md-3">
                <label for="field_title[${idx}]" class="form-label fw-bold">Título <span>*</span></label>
                <input type="text" class="form-control form-control-sm" id="field_title[${idx}]" name="fields[${idx}][title]" placeholder="Exemplo: Item">
            </div>
            <div class="col-md-2">
                <label for="field_tag[${idx}]" class="form-label fw-bold">Tipo (tag) <span>*</span></label>
                <select id="field_tag[${idx}]" name="fields[${idx}][tag]" class="form-select form-select-sm">
                    <option value="">Selecione</option>
                    <option value="input">input</option>
                    <option value="select">select</option>
                    <option value="check">check</option>
                    <option value="radio">radio</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="field_type_property[${idx}]" class="form-label fw-bold">Tipo (propriedade) <span>*</span></label>
                <select id="field_type_property[${idx}]" name="fields[${idx}][type_property]" class="form-select form-select-sm" onchange="functions.onchange_select_type(this);">
                    <option value="">Selecione</option>
                    <option value="text">text</option>
                    <option value="number">number</option>
                </select>
            </div>

            <div class="col-md-1 d-none">
                <label for="field_type_property[${idx}]" class="form-label fw-bold">step <span>*</span></label>
                <input type="number" step="0.1" class="form-control form-control-sm" min="0.1" value="1">
            </div>

            <div class="col-md-3">
                <label for="field_length[${idx}]" class="form-label fw-bold">Tamanho <span>*</span></label>
                <input type="number" step="1" class="form-control form-control-sm" id="field_length[${idx}]" name="fields[${idx}][length]" placeholder="Exemplo: 255">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn text-danger"><i class="ph ph-minus"></i></button>
            </div>
        </div>`
    );
  };

  this.get_next_idx = function () {
    const rows = container__fields.querySelectorAll(".row");
    console.log(rows);
    console.log(rows[rows.length - 1]);
    return parseInt(rows[rows.length - 1].dataset.idx) + 1;
  };
})();
