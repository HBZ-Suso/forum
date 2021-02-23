<div class="admin-visit-block admin-block" style="display: none;">
    <h2 class="admin-block-heading admin-visit-block-heading">Visitors</h2>
    <div class="visitor-view-settings">
        <label for="visit-start-field">Start Field</label>
        <input type="number" id="visit-start-field" name="visit-start-field" value="0"><br>
        <label for="visit-start-field">Show Size</label>
        <input type="number" id="visit-show-size" name="visit-show-size" value="100"><br>

        <label for="visit-set-field">Set Field</label>
        <input type="text" id="visit-set-field" name="visit-set-field" value=""><br>
        <label for="visit-to">To</label>
        <input type="text" id="visit-to" name="visit-to" value=""><br>

        <input type="submit" id="visit-submit" name="visit-submit" value="Save">
    </div>
    <table class="visitor-container sortable">
        <thead>
            <tr>
                <th>visitId</th>
                <th>userId</th>
                <th>visitIp</th>
                <th>visitPage</th>
                <th>visitDate</th>
                <th>visitData</th>
                <th>visitUserAgent</th>
            </tr>
        </thead>
        <tbody class="visitor-d-container">

        </tbody>
    </table>
</div>

<link rel="stylesheet" href="/forum/assets/admin/style/visitors.css">
<script src="/forum/assets/admin/script/visitors.js"></script>