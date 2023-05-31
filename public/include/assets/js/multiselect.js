class MultiSelect {

    constructor(elementId, option={}) {
        this.element =  document.querySelector(`#${elementId}`)
        if (!elementId) {
            throw 'Dropdown container does not exist';
        }
        this.option = option ? option : {};
        this.label = this.option.label || 'select option'

        this.designContainer()
    }

    designContainer() {
        this.element.classList.add("dropdown")
        const containerElement =
         `
                                <button type="button"
                                class="btn hov btn-primary-white btn-block dropdown-toggle"
                                data-toggle="dropdown" data-toggle="collapse" data-dropdown-btn="dropdownbtn-${this.element.id}">
                                <span>${this.label}</span>
                                </button>
                                                    <div class="dropdown-menu filter-country">
                                                        <form>
                                                            <div class="pt-0 pl-3 pr-3 pb-2">
                                                                <input type="text" class="form-control input-sm" data-search-box="search-box-${this.element.id}">
                                                            </div>
                                                            <div data-option-area="options-area-${this.element.id}">
                                                            </div>
                                                        </form>
                                                    </div>
        `;
        this.element.innerHTML = containerElement;
        const optionArea = this.element.querySelector(`[data-option-area="options-area-${this.element.id}"]`)
        optionArea.innerHTML = `
            <a class="dropdown-item" href="#">
                <label class="font-weight">
                <input type="checkbox" name="allselect" data-select-all-checkbox="select-all-checkbox-${this.element.id}">
                    Select All
                 </label>
            </a>`

        optionArea.innerHTML+= this.generateOption();
        this.bindEvents();
        this.onOptionChange(false);
        this.updateChecked()
    }

    generateOption() {
        let htmlContent = ``;
        const data = this.option.data;
        if (data?.length) {
            if (this.option.isGroup) {
                for (let index = 0; index < data.length; index++) {
                    const group = data[index];
                    let htmlOptionContent = `\n`;
                    if (group?.childern?.length) {
                        for (let optIndex = 0; optIndex < group.childern.length; optIndex++) {
                            const option = group.childern[optIndex];
                            htmlOptionContent += `
                            <a class="dropdown-item" href="#">
                                <label>
                                    <input type="checkbox" name="allselect" value="${option.value}" ${option.selected ? 'checked' : ''} data-select-option="select-option-${this.element.id}" data-parent-option-label="option-label-${this.element.id}-${this.spaceReplacer(group.label)}" data-option-label="option-label-${this.element.id}-${this.spaceReplacer(option.label)}"> ${option.label}
                                </label>
                            </a>
                            `
                        }
                    }
                    htmlContent += `\n
                    <div class="">
                            <a class="dropdown-item" href="#">
                                <label class="font-weight">
                                    <input type="checkbox" name="allselect" data-select-option-group="select-option-group-${this.element.id}" data-select-option-label="option-label-${this.element.id}-${this.spaceReplacer(group.label)}"> ${group.label}
                                </label>
                            </a>
                            <div class="pl-3">
                                ${htmlOptionContent}
                            </div>
                    </div>
                    `
                }
            } else {
               let htmlOptionContent = `\n`;
                for (let index = 0; index < data.length; index++) {
                    const option = data[index];
                    htmlOptionContent += `
                            <a class="dropdown-item" href="#">
                                <label>
                                    <input type="checkbox" name="allselect" value="${option.value}" ${option.selected ? 'checked' : ''} data-select-option="select-option-${this.element.id}" data-option-label="option-label-${this.element.id}-${this.spaceReplacer(option.label)}"> ${option.label}
                                </label>
                            </a>
                            `;
                }
                htmlContent += `\n
                    <div class="">
                            <div class="pl-3">
                                ${htmlOptionContent}
                            </div>
                    </div>
                    `
            }
        }
        return htmlContent;
    }

    bindEvents() {
        /*
        *   Select All on Change Event
         */
        this.element.querySelector(`[data-select-all-checkbox="select-all-checkbox-${this.element.id}"]`)?.addEventListener("change", (event) => {
            this.setAll(event.target.checked);
            this.onOptionChange();
        })
        if (this.option.isGroup) {

            const groupElements = Array.from(this.element.querySelectorAll(`[data-select-option-label]`));
            for (let index = 0; index < groupElements.length; index++) {
                const element = groupElements[index];
        /*
        *   Option Group on Change Event
        */
                element.addEventListener('change', (event) => {
                    const optGroup = event.target;
                    const childOptions = Array.from(this.element.querySelectorAll(`[data-parent-option-label="${optGroup.dataset.selectOptionLabel}"]`))
                    for (let opindx = 0; opindx < childOptions.length; opindx++) {
                        const option = childOptions[opindx];
                        option.checked = optGroup.checked;
                    }
                    const allOptionChecked = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`)).every(ele => ele.checked);
                    this.element.querySelector(`[data-select-all-checkbox="select-all-checkbox-${this.element.id}"]`).checked = allOptionChecked;
                    this.onOptionChange();
                })
            }
        }
        const allOptions = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`));
        for (let optIndx = 0; optIndx < allOptions.length; optIndx++) {
            const optionElements = allOptions[optIndx];
             /*
            *   Option on Change Event
            */
            optionElements.addEventListener("change", (event) => {
                const option = event.target;
                if (this.option.isGroup) {
                    const childOptionsChecked = Array.from(this.element.querySelectorAll(`[data-parent-option-label="${option.dataset.parentOptionLabel}"]`)).every(ele => ele.checked)
                    this.element.querySelector(`[data-select-option-label=${option.dataset.parentOptionLabel}]`).checked = childOptionsChecked
                }
                const allOptionChecked = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`)).every(ele => ele.checked);
                this.element.querySelector(`[data-select-all-checkbox="select-all-checkbox-${this.element.id}"]`).checked = allOptionChecked;
                this.onOptionChange()
            })
        }

        this.element.querySelector(`[data-search-box="search-box-${this.element.id}"]`).addEventListener('input', (event) => {
            const text = event.target.value;
            const allOptions = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`))
            for (let index = 0; index < allOptions.length; index++) {
                const element = allOptions[index];
                const label = element.dataset.optionLabel.replace(`option-label-${this.element.id}-`, '');
                if (!text || label.toLowerCase().includes(text.toLowerCase())) {
                    element.closest('a').classList.remove('hide')
                } else {
                    element.closest('a').classList.add('hide')
                }
                
            }
        })
    }

    setAll(checked) {
        const optionElements = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`))
        const optionGroupElements = Array.from(this.element.querySelectorAll(`[data-select-option-group="select-option-group-${this.element.id}"]`))
        if (optionElements?.length) {
            for (let index = 0; index < optionElements.length; index++) {
                const element = optionElements[index];
                if (element) {
                    element.checked = checked
                }
            }
        }
        if (optionGroupElements?.length) {
            for (let index = 0; index < optionGroupElements.length; index++) {
                const element = optionGroupElements[index];
                if (element) {
                    element.checked = checked
                }
            }
        }
    }

    onOptionChange(emit=true) {
        const allValues = this.getValue();
        const data = this.option.isGroup ? (this.option.data || []).flatMap(ele => ele.childern) : this.option.data
        if (allValues?.length) {
            if (allValues.length == data.length) {
                this.label = 'All Selected'
            } else {
                this.label = allValues.length + ' items selected'
            }
        } else {
            this.label = this.option.label || 'select option'
        }

        this.element.querySelector(`[data-dropdown-btn="dropdownbtn-${this.element.id}"]>span`).innerHTML = this.label

        if (this.option.onChange) {
            this.option.onChange(allValues);
        }
    }

    getValue() {
        return Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]:checked`)).map(d => d.value)
    }

    updateChecked() {
        if (this.option.isGroup) {
            const allGroup = [...new Set(Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`)).map(d => d.dataset.parentOptionLabel))]
            for (let index = 0; index < allGroup.length; index++) {
                const option = allGroup[index];
                const childOptionsChecked = Array.from(this.element.querySelectorAll(`[data-parent-option-label="${option}"]`)).every(ele => ele.checked)
                
                this.element.querySelector(`[data-select-option-label=${option}]`).checked = childOptionsChecked
            }
        }

        const optionChecked = Array.from(this.element.querySelectorAll(`[data-select-option="select-option-${this.element.id}"]`)).every(ele => ele.checked);
        this.element.querySelector(`[data-select-all-checkbox="select-all-checkbox-${this.element.id}"]`).checked = optionChecked;
    }

    spaceReplacer(text) {
        return text.replaceAll(' ', '_');
    }
} 