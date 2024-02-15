<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>LOGIN</legend>
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php if (isset($content)) { echo $content->getId(); } ?>" />
            <label>Password *:</label>
            <input type="text" placeholder="Name" name="password" value="<?php if (isset($content)) { echo $content->getName(); } ?>" />

            <label>* Required fields</label>
            <input type="submit" name="action" value="submit" />
            <input type="submit" name="reset" value="reset"  />
        </fieldset>
    </form>
</div>