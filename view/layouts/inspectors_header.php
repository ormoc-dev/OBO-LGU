<?php
// Inspectors Dashboard Header Component
?>
<style>
.user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    text-align: right;
}

.user-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.user-role {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 400;
}
</style>
<header class="mech-topbar">
    <div class="topbar-left">
        <img src="/OBO-LGU/images/obo.png" alt="LGU" class="logo">
    </div>
    <div class="topbar-right">
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($user['username'] ?? 'Inspector'); ?></span>
            <span class="user-role"><?php 
                $department = $user['role'] ?? 'admin';
                $departmentNames = [
                    'electrical/electronics' => 'Electrical Inspector',
                    'architectural' => 'Architectural Inspector',
                    'mechanical' => 'Mechanical Inspector',
                    'civil/structural' => 'Civil Inspector',
                    'line/grade' => 'Line & Grade Inspector',
                    'sanitary/plumbing' => 'Sanitary Inspector'
                ];
                echo $departmentNames[$department] ?? 'Inspector';
            ?></span>
        </div>
    </div>
</header>
