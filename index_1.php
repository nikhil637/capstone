<?php
error_reporting(E_ALL);  // Report all types of errors
ini_set('display_errors', 1);  // Display errors on the page
?>
<?php
// Initialize variables
$net_taxable_income = $tax = $net_income_after_tax = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $salary = isset($_POST['salary']) ? (float) $_POST['salary'] : 0;
    $bonus = isset($_POST['bonus']) ? (float) $_POST['bonus'] : 0;
    $other_income = isset($_POST['other_income']) ? (float) $_POST['other_income'] : 0;
    $hra = isset($_POST['hra']) ? (float) $_POST['hra'] : 0;
    $pension = isset($_POST['pension']) ? (float) $_POST['pension'] : 0;
    $health_insurance = isset($_POST['health_insurance']) ? (float) $_POST['health_insurance'] : 0;

    // Calculate Net Taxable Income
    $net_taxable_income = ($salary * 12) - ($hra * 12) - 50000 - ($pension * 12) - ($health_insurance * 12);

    // Simplified Tax Calculation
    if ($net_taxable_income <= 500000) {
        $tax = 0; // No tax if income is below or equal to ₹500,000
    } elseif ($net_taxable_income > 500000 && $net_taxable_income <= 1000000) {
        $tax = 12500 + 0.20 * ($net_taxable_income - 500000);
    } else {
        $tax = 112500 + 0.30 * ($net_taxable_income - 1000000);
    }

    // Calculate Net Income after Tax
    $net_income_after_tax = $net_taxable_income - $tax;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Tax Calculation</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form-container">
        <h1>Income Tax Calculation</h1>
        <form action="index_1.php" method="POST">
            <label for="salary">Annual Salary (₹):</label>
            <input type="number" name="salary" id="salary" required>

            <label for="bonus">Bonus (₹):</label>
            <input type="number" name="bonus" id="bonus">

            <label for="other_income">Other Taxable Income (₹):</label>
            <input type="number" name="other_income" id="other_income">

            <label for="hra">House Rent Allowance (HRA) (₹):</label>
            <input type="number" name="hra" id="hra">

            <label for="pension">Pension Contribution (₹):</label>
            <input type="number" name="pension" id="pension">

            <label for="health_insurance">Health Insurance Premium (₹):</label>
            <input type="number" name="health_insurance" id="health_insurance">

            <button type="submit">Calculate Tax</button>
        </form>

        <!-- Display the calculated results -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="result">
                <h2>Tax Calculation Summary</h2>
                <p><strong>Net Taxable Income:</strong> ₹<?php echo number_format($net_taxable_income, 2); ?></p>
                <p><strong>Total Tax Liability:</strong> ₹<?php echo number_format($tax, 2); ?></p>
                <p><strong>Net Income After Tax:</strong> ₹<?php echo number_format($net_income_after_tax, 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>