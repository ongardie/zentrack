<? if( !empty($ticket['project_id']) || !empty($ticket['children']) ) { 
  

function findRootProject(&$zen, $pid) {
  $project = $zen->get_project($pid);
  if( empty($project['project_id']) ) { return $project; }
  return findRootProject($zen, $project['project_id']);
}

function buildProjectTree(&$zen, &$rootUrl, &$project, $last = false, $depth = 0, $parentId=false) {
  $marginWidth = 15;
  // print this project at whatever level we're on
  $pid = $project['id'];
  if( $depth ) { $parentNode = "projectTreeNodes['$parentId']"; }
  else { $parentNode = 'false'; }
  jsTreeNode($zen, $rootUrl, $parentNode, $project);
  
  // parse the children
  if( !empty($project['children']) ) {
    // set this here rather than int he foreach loop (only need to build it once)
    $parentNode = "projectTreeNodes['$pid']";
    foreach($project['children'] as $p) {
      if( $zen->inProjectTypeIds($p['type_id']) ) {
        // this is a project, so we indent and recurse
        // we have to get the project each time, because the children
        // of a project don't have their children loaded yet
        buildProjectTree($zen, $rootUrl, $zen->get_project($p['id']), $last, $depth+1, $pid);
      }
      else {
        // this isn't a project, just add it as a node now
        jsTreeNode($zen, $rootUrl, $parentNode, $p);
      }
    }
  }
}

function jsTreeNode(&$zen, &$rootUrl, $parentNode, $ticket) {
  $pid = $ticket['id'];
  $type = $zen->getTypeName($ticket['type_id']);
  $ttl = $zen->fixJsHtml("$type #$pid: {$ticket['title']}");
  print "\taddNode({'label': $ttl, 'title': $ttl, 'href': \"$rootUrl/project.php?id=$pid\"}, $parentNode, $pid);\n";
}
  
?>
<div class='borderBox yui-skin-sam'>
  <div class='borderLabel'><span><?=uptr("Project Tree")?></span></div>
  <div class='project-links'>
     <a id='project-tree-expand' href='#'><img src='<?=$rootUrl?>/images/bottom.png' title='Expand All'></a>
     <a id='project-tree-collapse' href='#'><img src='<?=$rootUrl?>/images/collapse.png' title='Collapse All'></a>
  </div>
  <div id='project-tree'>
  </div>
</div>

<script type='text/javascript'>
//global variable to allow console inspection of tree:
var tree;

//anonymous function wraps the remainder of the logic:
(function() {

	//function to initialize the tree:
    function treeInit() {
		//instantiate the tree:
        tree = new YAHOO.widget.TreeView("project-tree");
        var projectTreeNodes = { };
        function addNode(n, p, id) {
          if( !p ) { p = tree.getRoot(); }
          projectTreeNodes[id] = new YAHOO.widget.TextNode(n, p, false);
        }
<?
$rootProject = !empty($ticket['project_id'])? findRootProject($zen, $ticket['project_id']) : $ticket;
buildProjectTree($zen, $rootUrl, $rootProject);
?>

         // Trees with TextNodes will fire an event for when the label is clicked:
         tree.subscribe("labelClick", function(node) {
                YAHOO.log(node.index + " label was clicked", "info", "example");
             });
         
         //handler for expanding all nodes
         YAHOO.util.Event.on("project-tree-expand", "click", function(e) {
             tree.expandAll();
             YAHOO.util.Event.preventDefault(e);
         });
         
         //handler for collapsing all nodes
         YAHOO.util.Event.on("project-tree-collapse", "click", function(e) {
             tree.collapseAll();
             YAHOO.util.Event.preventDefault(e);
         });
         
         tree.draw();
    }
    
    //Add a window onload handler to build the tree when the load 
  	//event fires. 
  	YAHOO.util.Event.addListener(window, "load", treeInit); 
    
})();
</script>

<? } ?>

