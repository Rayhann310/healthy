        </div> <!-- end content -->
        
        <footer class="footer">
            &copy; <?= date('Y') ?> KathaHealthy. All rights reserved.
        </footer>
    </div> <!-- end main-content -->

    <script>
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            var sidebar = document.getElementById('sidebar');
            var toggleBtn = document.querySelector('.mobile-toggle');
            
            // If click is outside sidebar and toggle button, and sidebar is open
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
