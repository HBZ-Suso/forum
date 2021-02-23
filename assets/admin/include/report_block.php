<div class="admin-report-block admin-block" style="display: none;">
    <h2 class="admin-block-heading admin-report-block-heading">Reports</h2>
    <div class="report-view-settings">
        <label for="report-start-field">Start Field</label>
        <input type="number" id="report-start-field" name="report-start-field" value="0"><br>
        <label for="report-start-field">Show Size</label>
        <input type="number" id="report-show-size" name="report-show-size" value="100"><br>

        <label for="report-set-field">Set Field</label>
        <input type="text" id="report-set-field" name="report-set-field" value=""><br>
        <label for="report-to">To</label>
        <input type="text" id="report-to" name="report-to" value=""><br>

        <input type="submit" id="report-submit" name="report-submit" value="Save">
    </div>
    <table class="report-container sortable">
        <thead>
            <tr>
                <th>reportId</th>
                <th>reportTitle</th>
                <th>reportDate</th>
                <th>reportIp</th>
                <th>userId</th>
                <th>Report</th>
            </tr>
        </thead>
        <tbody class="report-d-container">

        </tbody>
    </table>
</div>

<link rel="stylesheet" href="/forum/assets/admin/style/report.css">
<script src="/forum/assets/admin/script/report.js"></script>