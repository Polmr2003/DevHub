<div id="content">
    <table class="table">

        <thead class="thead-light">
        <tr>
            <th>Nif</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($content as $element)
        {
            // Each element of the array $content is an owner
            echo "<tr>";
            echo "<td>{$element->getNif()}</td>";
            echo "<td>{$element->getName()}</td>";
            echo "<td>{$element->getEmail()}</td>";
            echo "<td>{$element->getPhone()}</td>";
            echo '<td><button class="btn btn-warning"><a href="index.php?menu=owner&option=update&nif=' . $element->getNif() . '" style="text-decoration: none;">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="index.php?menu=owner&option=delete&nif=' . $element->getNif() . '" style="text-decoration: none;">Delete</a></button></td>';
            echo "</tr>";
        }
        ?>
        </tbody>

    </table>
</div>