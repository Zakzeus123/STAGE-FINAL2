 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center bg-gradient-primary justify-content-center" href="index.php">
        <div class="sidebar-brand-icon" >
          <img src="img/logo/attnlg.jpg">
        </div>
        <div class="sidebar-brand-text mx-3">AMS</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li> 
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Cours et Classes
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClasses" aria-expanded="true" aria-controls="collapseClasses">
            <i class="fas fa-chalkboard"></i>
            <span>Gérer les classes</span>
        </a>
        <div id="collapseClasses" class="collapse" aria-labelledby="headingClasses" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gérer les classes</h6>
                <a class="collapse-item" href="viewClasses.php"><i class="fas fa-eye"></i> Voir les classes</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Enseignants
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapseTeachers">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Voir les enseignants</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingTeachers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Liste des enseignants</h6>
                <a class="collapse-item" href="viewTeachers.php"><i class="fas fa-eye"></i> Voir les enseignants</a>
            </div>
        </div>
    </li>
    
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Session & Semestre
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSession" aria-expanded="true" aria-controls="collapseSession">
        <i class="fas fa-layer-group"></i>
            <span>Voir les sessions & semestres</span>
        </a>
        <div id="collapseSession" class="collapse" aria-labelledby="headingSession" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion des sessions</h6>
                <a class="collapse-item" href="viewSessionTerm.php"><i class="fas fa-eye"></i> Voir les sessions et <br> semestres</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!--   <div class="sidebar-heading">
        profisseur
      </div>
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2"
          aria-expanded="true" aria-controls="collapseBootstrap2">
          <i class="fas fa-user-graduate"></i>
          <span>Manage profisseur</span>
        </a>
        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage profisseur</h6>
            <a class="collapse-item" href="viewStudents.php">View profisseur</a>
            <a class="collapse-item" href="#">Assets Type</a>
          </div>
        </div>
      </li> -->
      
      <div class="sidebar-heading">
      Voir emploi du temps
    </div>
    </li>
     <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
        aria-expanded="true" aria-controls="collapseBootstrapcon">
        <i class="fas fa-user-check"></i>
        <span>Les emplois du temps</span>
      </a>
      <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Gestion des emplois du temps</h6>
          <a class="collapse-item" href="emploi.php"><i class="fas fa-eye"></i> Emploi du temps</a>
          <a class="collapse-item" href="emploiExam.php"><i class="fas fa-eye"></i> Emploi des examens</a>
          <a class="collapse-item" href="telechargerConvocation.php">Télécharger convocation</a>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
    <i class="fas fa-clipboard-list"></i> Gestion des Notes
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotes" 
       aria-expanded="true" aria-controls="collapseNotes">
        <i class="fas fa-graduation-cap"></i> <!-- Icône pour les notes -->
        <span>Gérer les notes</span>
    </a>
    <div id="collapseNotes" class="collapse" aria-labelledby="headingNotes" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><i class="fas fa-tasks"></i> Options de gestion</h6> <!-- Icône ajoutée -->
            <a class="collapse-item" href="gard.php">
                <i class="fas fa-eye"></i> Voir les notes
            </a> <!-- Icône ajoutée -->
            <a class="collapse-item" href="telechargerRelever.php">Télécharger relever de<br>note</a>
        </div>
    </div>
</li>



     
      <!-- <li class="nav-item">
        <a class="nav-link" href="forms.html">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Forms</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tables</h6>
            <a class="collapse-item" href="simple-tables.html">Simple Tables</a>
            <a class="collapse-item" href="datatables.html">DataTables</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ui-colors.html">
          <i class="fas fa-fw fa-palette"></i>
          <span>UI Colors</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">hhhfxftdttdhafsaben
        Examples
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Example Pages</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span>
        </a>
      </li> -->
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
    Gestion Des Annonces
</div>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnonces" aria-expanded="true" aria-controls="collapseAnnonces">
        <i class="fas fa-bullhorn"></i>
        <span>Gérer les annonces</span>
    </a>
    <div id="collapseAnnonces" class="collapse" aria-labelledby="headingAnnonces" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gérer les annonces</h6>
            <a class="collapse-item" href="voirAnnonce.php">
            <i class="fas fa-eye"></i> Voir les annonces</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
     
    </ul>