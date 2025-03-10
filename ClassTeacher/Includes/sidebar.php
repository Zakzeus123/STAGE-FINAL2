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
          <span>Tableau de bord</span></a>
      </li> 
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Etudiants
      </div>
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2"
          aria-expanded="true" aria-controls="collapseBootstrap2">
          <i class="fas fa-user-graduate"></i>
          <span>Gérer Etudiants</span>
        </a>
        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gérer Etudiants</h6>
            <a class="collapse-item" href="viewStudents.php">Voir Etudiants</a>
            <!-- <a class="collapse-item" href="#">Assets Type</a> -->
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
      Présence
      </div>
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
          aria-expanded="true" aria-controls="collapseBootstrapcon">
          <i class="fas fa-user-check"></i>
          <span>Gérer La Présence</span>
        </a>
        <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gérer La Présence</h6>
            <a class="collapse-item" href="takeAttendance.php">Prendre La Présence</a>
            <a class="collapse-item" href="viewAttendance.php">Voir Class Présence</a>
            <a class="collapse-item" href="viewStudentAttendance.php"> Voir Etudiant Présence</a>
            <!-- <a class="collapse-item" href="downloadRecord.php">Today's Report (xls)</a> -->
            <!-- <a class="collapse-item" href="addMemberToContLevel.php ">Add Member to Level</a> -->
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
  <div class="sidebar-heading">
    Emploi du temps
  </div>
</li>

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTimetable"
    aria-expanded="true" aria-controls="collapseTimetable">
    <i class="fa fa-calendar-alt"></i>
    <span>Voir emploi</span>
  </a>
  <div id="collapseTimetable" class="collapse" aria-labelledby="headingTimetable" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Voir emploi</h6>
      <a class="collapse-item" href="downloadRecord.php">Consulter l'emploi du temps</a> 
      <a class="collapse-item" href="downloadTimetable.php">Télécharger (PDF)</a> 
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
      <div class="sidebar-heading">
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
            <a class="collapse-item" href="creerAnnonce.php">Créer une annonce</a>
            <br>
            <a class="collapse-item" href="voirAnnonce.php">Voir les annonces</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
     Gestion des notes
   </div>
   </li>
   <li class="nav-item">
     <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstraphcon"
       aria-expanded="true" aria-controls="collapseBootstrapcon">
       <i class="fas fa-pencil-alt"></i>
       <span>Gestion des notes</span>
     </a>
     <div id="collapseBootstraphcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">
         <h6 class="collapse-header">gree note</h6>
         <a class="collapse-item" href="gerNote.php">Créer une note</a>
         <a class="collapse-item" href="calculenote.php">Voir les notes</a>
         </div>
         </li>
         
         <hr class="sidebar-divider">
<div class="sidebar-heading">
    Gestion des devoirs
</div>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDevoirs"
       aria-expanded="true" aria-controls="collapseDevoirs">
        <i class="fas fa-book"></i>
        <span>Gestion des devoirs</span>
    </a>
    <div id="collapseDevoirs" class="collapse" aria-labelledby="headingDevoirs" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Devoirs</h6>
            <a class="collapse-item" href="viewhomeWork.php">Voir les devoirs</a>
        </div>
    </div>
</li>



    </ul>