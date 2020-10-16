<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4/dist/autoNumeric.min.js"></script>
<script>
 var currency = {
                    alwaysAllowDecimalCharacter: true,
                    caretPositionOnFocus: "start",
                    currencySymbol: "$",
                    decimalCharacter: ",",
                    decimalCharacterAlternative: ".",
                    digitGroupSeparator: ".",
                    minimumValue: 0.00,
                    emptyInputBehavior: "min",
                    modifyValueOnWheel: false,
                    unformatOnSubmit: true
                };

var currency_neg = {
                    alwaysAllowDecimalCharacter: true,
                    caretPositionOnFocus: "start",
                    currencySymbol: "$",
                    decimalCharacter: ",",
                    decimalCharacterAlternative: ".",
                    digitGroupSeparator: ".",
                    emptyInputBehavior: "min",
                    modifyValueOnWheel: false,
                    unformatOnSubmit: true
                };

var decimal = {
                caretPositionOnFocus: "start",
                decimalCharacter: ",",
                decimalCharacterAlternative: ".",
                digitGroupSeparator: ".",
                minimumValue: 0.00,
                emptyInputBehavior: "min",
                modifyValueOnWheel: false,
                unformatOnSubmit: true
            }

var integer = {
                caretPositionOnFocus: "start",
                decimalCharacter: ",",
                decimalPlaces: 0,
                digitGroupSeparator: ".",
                minimumValue: 0.00,
                emptyInputBehavior: "min",
                modifyValueOnWheel: false,
                unformatOnSubmit: true
            }

var percentage = {
                caretPositionOnFocus: "start",
                decimalCharacter: ",",
                decimalCharacterAlternative: ".",
                decimalPlaces: 2,
                digitGroupSeparator: ".",
                minimumValue: 0.00,
                emptyInputBehavior: "min",
                modifyValueOnWheel: false,
                symbolWhenUnfocused: "%",
                unformatOnSubmit: true
            }
</script>