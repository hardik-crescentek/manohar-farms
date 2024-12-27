function onlyNumbers(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode < 48 || charCode > 57) {
        return false;
    }
    return true;
}

function onlyDecimal(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57) && charCode != 46) {
        return false;
    }
    return true;
}

function validatePhoneNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57) && charCode != 43) {
        return false;
    }
    return true;
}

function validateNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57) && charCode == 43) {
        return false;
    }
    return true;
}