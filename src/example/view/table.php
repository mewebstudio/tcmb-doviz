<table border="1">
    <thead>
    <tr>
        <td colspan="8" style="text-align: center;"><strong>Date:</strong> <?php echo $currency->getDate(); ?></td>
    </tr>
    <tr>
        <th>Currency Code</th>
        <th>Currency Name</th>
        <th>Forex Buying</th>
        <th>Forex Selling</th>
        <th>Banknote Buying</th>
        <th>Banknote Selling</th>
        <th>Cross Rate USD</th>
        <th>Cross Rate Other</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($currency->getItems() as $item): ?>
    <tr>
        <th><?php echo $item->CurrencyCode; ?></th>
        <th><?php echo $item->CurrencyName; ?></th>
        <td><?php echo $item->ForexBuying; ?></td>
        <td><?php echo $item->ForexSelling; ?></td>
        <td><?php echo $item->BanknoteBuying; ?></td>
        <td><?php echo $item->BanknoteSelling; ?></td>
        <td><?php echo $item->CrossRateUSD; ?></td>
        <td><?php echo $item->CrossRateOther; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
