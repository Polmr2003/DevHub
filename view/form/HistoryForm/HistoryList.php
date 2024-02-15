<div id="content">
    <table class="table">

        <thead class="thead-light">
        <tr>
            <th>Nif</th>
            <th>PetID</th>
            <th>Date</th>
            <th>Motive</th>
            <th>Desc</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($content as $element)
        {
            // Each element of the array $content is an owner
            echo "<tr>";
            echo "<td>{$element->getId()}</td>";
            echo "<td>{$element->getIdPet()}</td>";
            echo "<td>{$element->getDate()}</td>";
            echo "<td>{$element->getMotive()}</td>";
            echo "<td>{$element->getDesc()}</td>";
            echo "</tr>";
        }
        ?>
        </tbody>

    </table>
</div>