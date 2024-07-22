<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dropdown to Checkbox Example</title>
<style>
    .hidden {
        display: none;
    }
</style>
</head>
<body>

<select id="dropdown">
    <option value="option1">Option 1</option>
    <option value="option2">Option 2</option>
    <option value="option3">Option 3</option>
</select>

<div id="checkboxes">
    <div id="option1" class="hidden">
        <input type="checkbox" id="checkbox1" name="checkbox1" value="checkbox1">
        <label for="checkbox1">Checkbox 1</label><br>
        <input type="checkbox" id="checkbox2" name="checkbox2" value="checkbox2">
        <label for="checkbox2">Checkbox 2</label><br>
    </div>
    <div id="option2" class="hidden">
        <input type="checkbox" id="checkbox3" name="checkbox3" value="checkbox3">
        <label for="checkbox3">Checkbox 3</label><br>
        <input type="checkbox" id="checkbox4" name="checkbox4" value="checkbox4">
        <label for="checkbox4">Checkbox 4</label><br>
    </div>
    <div id="option3" class="hidden">
        <input type="checkbox" id="checkbox5" name="checkbox5" value="checkbox5">
        <label for="checkbox5">Checkbox 5</label><br>
        <input type="checkbox" id="checkbox6" name="checkbox6" value="checkbox6">
        <label for="checkbox6">Checkbox 6</label><br>
    </div>
</div>

<script>
    document.getElementById('dropdown').addEventListener('change', function() {
        var selectedOption = this.value;
        var checkboxes = document.getElementById('checkboxes').children;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].classList.add('hidden');
        }

        document.getElementById(selectedOption).classList.remove('hidden');
    });
</script>

</body>
</html>
