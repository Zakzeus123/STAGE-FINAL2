 <ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
     <a class="sidebar-brand d-flex align-items-center bg-gradient-primary  justify-content-center" href="index.php">
         <div class="sidebar-brand-icon">
             <img src="img/logo/attnlg.jpg">
         </div>
         <div class="sidebar-brand-text mx-3">Code Camp BD</div>
     </a>
     <hr class="sidebar-divider my-0">
     <li class="nav-item active">
         <a class="nav-link" href="index.php">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>
     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Class and Class Arms
     </div>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
             <i class="fas fa-chalkboard"></i>
             <span>Manage Classes</span>
         </a>
         <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Classes</h6>
                 <a class="collapse-item" href="createClass.php">Create Class</a>
                 <!-- <a class="collapse-item" href="#">Member List</a> -->
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapusers" aria-expanded="true" aria-controls="collapseBootstrapusers">
             <i class="fas fa-code-branch"></i>
             <span>Manage Class Arms</span>
         </a>
         <div id="collapseBootstrapusers" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Class Arms</h6>
                 <a class="collapse-item" href="createClassArms.php">Create Class Arms</a>
                 <!-- <a class="collapse-item" href="usersList.php">User List</a> -->
             </div>
         </div>
     </li>
     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Enseignants
     </div>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassests" aria-expanded="true" aria-controls="collapseBootstrapassests">
             <i class="fas fa-chalkboard-teacher"></i>
             <span>Gérer les Enseignants</span>
         </a>
         <div id="collapseBootstrapassests" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Gérer les Enseignants <br> de Classe</h6>
                 <a class="collapse-item" href="createClassTeacher.php">Créer un Enseignant <br> de Classe</a>
                  <a class="collapse-item" href="takeTeacherAttendance.php">Prendre la Présence <br> des Enseignants</a>
                 <a class="collapse-item" href="viewTeacherAttendance.php">Voir la Présence <br> des Enseignants</a> 
             </div>
         </div>
     </li>
     <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapschemes"
          aria-expanded="true" aria-controls="collapseBootstrapschemes">
          <i class="fas fa-home"></i>
          <span>Manage Schemes</span>
        </a>
        <div id="collapseBootstrapschemes" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Schemes</h6>
             <a class="collapse-item" href="createSchemes.php">Create Scheme</a>
            <a class="collapse-item" href="schemeList.php">Scheme List</a>
          </div>
        </div>
      </li> -->

     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Students
     </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true" aria-controls="collapseBootstrap2">
             <i class="fas fa-user-graduate"></i>
             <span>Manage Students</span>
         </a>
         <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Students</h6>
                 <a class="collapse-item" href="createStudents.php">Create Students</a>
                 <!-- <a class="collapse-item" href="#">Assets Type</a> -->
             </div>
         </div>
     </li>

     <hr class="sidebar-divider">
     <div class="sidebar-heading">
         Session & Term
     </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon" aria-expanded="true" aria-controls="collapseBootstrapcon">
             <i class="fa fa-calendar-alt"></i>
             <span>Manage Session & Term</span>
         </a>
         <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Contribution</h6>
                 <a class="collapse-item" href="createSessionTerm.php">Create Session and Term</a>
                 <!-- <a class="collapse-item" href="addMemberToContLevel.php ">Add Member to Level</a> -->
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
        Gestion De L'Emploi Du Temps
     </div>
      <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassestsrt" aria-expanded="true" aria-controls="collapseBootstrapassests">
         <i class="fas fa-user-check"></i>
             <span>Gérer l'emploi du temps</span>
         </a>
         <div id="collapseBootstrapassestsrt" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Gérer l'emploi du temps</h6>
                 <a class="collapse-item" href="index2.php">Créer un emploi du temps</a>
                 <br>
                 <a class="collapse-item" href="emploiExamSt.php">Créer un emploi du temps <br> des examens</a>
                 <a class="collapse-item" href="toutEmploi.php">Voir emploi du temps <br> Etudiants</a>
                 <a class="collapse-item" href="toutEmploiTeach.php">Voir emploi du temps <br> Enseignants</a>

                 <!-- <a class="collapse-item" href="assetsCategoryList.php">Assets Category List</a>
             <a class="collapse-item" href="createAssets.php">Create Assets</a>

             <h6 class="collapse-header">view emploi</h6>
                 <a class="collapse-item" href=".php">view emploi</a> -->
                  
             </div>
         </div>
     </li>
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


 </ul>