var App = angular.module('drag-and-drop', ['ngDragDrop']);
App.controller('oneCtrl', dragDropController);

function dragDropController($scope) {
  $scope.defaultList = [
    { id: 1, firstName: 'Mary', lastName: 'Goodman', role: 'manager', approved: true, points: 34 },
    { id: 2, firstName: 'Mark', lastName: 'Wilson', role: 'developer', approved: true, points: 4 },
    { id: 3, firstName: 'Alex', lastName: 'Davies', role: 'admin', approved: true, points: 56 },
    { id: 4, firstName: 'Bob', lastName: 'Banks', role: 'manager', approved: false, points: 14 },
    { id: 5, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 },
    { id: 6, firstName: 'Jason', lastName: 'Durham', role: 'developer', approved: false, points: 0 },
    { id: 7, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 },
    { id: 8, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 },
    { id: 9, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 },
    { id: 10, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 },
    { id: 11, firstName: 'David', lastName: 'Stevens', role: 'developer', approved: false, points: 100 }
  ];

  $scope.defaultSelected = [];
  $scope.lists = [];
  $scope.trashList = [];
  $scope.changedTitle = "";

  $scope.changeTitle = function (list) {
    var val = document.getElementById("tc" + list.id).value;
    if (val && val.trim())
      list.title = val;
  }

  $scope.addList = function () {
    var list = {
      id: 'id' + ($scope.lists.length + 1),
      title: 'List' + ($scope.lists.length + 1),
      items: [],
      selected: []
    };
    $scope.lists.push(list);
  }
  $scope.dragging = false;
  $scope.sourcelist = null;

  $scope.deselectOthers = function (id) {
    if (id != 'defaultList') {
      $("#" + id).siblings().find('input[type=checkbox]').prop('checked', false);
      $("#defaultList").find('input[type=checkbox]').prop('checked', false);
      for(var item of $scope.defaultList){
        item.selected=false;
      }
    }
    else
      $('.dl').find('input[type=checkbox]').prop('checked', false);
  }
  $scope.removeList = function (list) {
    if (list.items.length > 0)
      return;
    var index = $scope.lists.indexOf(list);
    $scope.lists.splice(index, 1);
  }
  function compare(a, b) {
    if (a.firstName < b.firstName)
      return -1;
    if (a.firstName > b.firstName)
      return 1;
    return 0;
  }
  function sortLists() {
    $scope.defaultList.sort(compare);
    if ($scope.lists.length > 0) {
      for (var list of $scope.lists) {
        if (list && list.items) {
          list.items.sort(compare);
        }
      }
    }
  }

  $scope.stopDrag = function (list, item) {
    // console.log("stopDrag, dragging = "+$scope.dragging);
    item.selected = false;
    var selected = [];
    if ($scope.dragging == false) {
      if (typeof item === 'undefined') {
        return;
      }
      if (list == -1) {
        // console.log("Moving from main list");
        $scope.sourcelist = $scope.defaultList;
        $scope.dragging = true;
      }
      else {
        // console.log("Moving from list " + list.title);
        $scope.sourcelist = list.items;
        $scope.dragging = true;
      }
    }
    else if ($scope.sourcelist != null) {
      // console.log("Drop end");		
      // console.log($scope.sourcelist);
      for (var i = $scope.sourcelist.length - 1; i >= 0; i--) {
        var value = $scope.sourcelist[i];
        if (value.selected == 'true') {
          // console.log("Selezionato " + value.id);
          if (list == -1) {
            // console.log("Moving to main list");					
            var element = $scope.sourcelist.splice(i, 1);
            $scope.defaultList.push(element[0]);
          }
          else {
            // console.log("Moving to list " + list.title);
            var element = $scope.sourcelist.splice(i, 1);
            // console.log(element[0])
            // console.log(element[0])
            list.items.push(element[0]);
          }
        }
      };
      $scope.dragging = false;
      setTimeout(function () {
        $scope.dragging = false;
        // console.log("DRAGGING=false");
      }, 50);
    }
    else {
      $scope.dragging = false;
    }
    sortLists();
  };
  sortLists();
  $scope.Drop = function (list) {
    sortLists();
  };
}
