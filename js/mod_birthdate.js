var sysdata = new Date();

document.id('birthdate-input-date').value = "";
document.id('birthdate-id').value = "";

Calendar.setup({
    inputField: "birthdate-id",
    ifFormat: "%d - %m -%Y",
    range: sysdata.getFullYear()
});

var birthdateTable = document.id('birthdate-table');

/*SEARCH BY DATE*/
var requestDate = new Request({
    url: 'modules/mod_birthdate/ajax/getBirthdate.php',
    method: 'post',
    onRequest: function () {
        var loaderElement = new Element('div', {'class': 'loading-birthdate', 'id': 'loading-id'});
        loaderElement.inject(birthdateTable, 'top');
    },
    onSuccess: function (responseText) {
        document.id('birthdate-tbody').innerHTML = responseText;
    },
    onFailure: function () {
        alert('A opção de pesquisa está inacessível no momento, caso ainda ocorra favor nos informe através do nosso contato');
    },
    onComplete: function () {
        document.id('loading-id').destroy();
    }
});

/*ATIVANDO A BUSCA NO CLIQUE DO CALENDARIO*/
function findBirthday(value) {
    document.id('birthdate-input-date').value = "";
    document.id('autocomplete-suggestions').style.display = "none";
    requestDate.send('date=' + value + '&id=' + document.id('module-id').get('value') + '&type=date');
}
/*SEARCH BY DATE*/
/*****************************************************************************************************/

/*SEARCH BY NAME*/
/**
 * Comment
 */
function getBirthdateAjax() {
    if(this.value.length >= 3 ){
        document.id('birthdate-id').value = "";
        new Request({
            url: 'modules/mod_birthdate/ajax/getBirthdate.php',
            method: 'post',
            onSuccess: function (responseText) {
                if(responseText){
                    document.id('autocomplete-suggestions').style.display = "block";
                    document.id('autocomplete-suggestions').innerHTML = responseText;
                }
            },
            onFailure: function () {
                document.id('autocomplete-suggestions').style.display = "none";
                alert('A opção de pesquisa está inacessível no momento, caso ainda ocorra favor nos informe através do nosso contato');
            }
        }).send('&id=' + document.id('module-id').get('value') + '&type=name&value=' + this.value);
        new Request({
            url: 'modules/mod_birthdate/ajax/getBirthdate.php',
            method: 'post',
            onSuccess: function (responseText) {
                if(responseText){
                    document.id('autocomplete-suggestions').style.display = "block";
                    document.id('autocomplete-suggestions').innerHTML = responseText;
                }
            },
            onFailure: function () {
                document.id('autocomplete-suggestions').style.display = "none";
                alert('A opção de pesquisa está inacessível no momento, caso ainda ocorra favor nos informe através do nosso contato');
            }
        }).send('&id=' + document.id('module-id').get('value') + '&type=name&value=' + this.value);
    }
}

document.addEvent("click", function(){document.id('autocomplete-suggestions').style.display = "none";});
document.id('birthdate-input-date').addEventListener("keyup", getBirthdateAjax);
document.id('birthdate-input-date').addEventListener("click", getBirthdateAjax);
document.id('birthdate-input-date').addEventListener("blur", function(){
    if(this.value == ""){
        if(document.id('birthdate-id').value == "" ){
            var today = document.id('sysdate').value;
            findBirthday(today);
        }
        
        document.id('autocomplete-suggestions').style.display = "none";
    }
});

function findBirthdayByName(elem) {
    var d = elem.getAttribute("data");
    requestDate.send('data=' + d + '&id=' + document.id('module-id').get('value') + '&type=date');
    document.id('birthdate-id').value = "";
    document.id('autocomplete-suggestions').style.display = "none";
}
/*SEARCH BY NAME*/