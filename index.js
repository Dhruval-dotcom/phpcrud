function loadtable() {
  $("#main-content").load("table.php");
}

var orderno = 0;
var pagesize = 5;
var pagenumber = 1;
loadtable();

$("#insert").on("submit", function (e) {
  e.preventDefault();
  let id = $("#idrow").val();
  let boxes =
    document.getElementById("customCheck1").checked ||
    document.getElementById("customCheck2").checked ||
    document.getElementById("customCheck3").checked;
  if (id == "") {
    let conditionform = 1;
    if ($("#name").val() == "") {
      $("#alert").html("Enter Name");
      $("#alert").css("display", "block");
      conditionform = 0;
    } else if ($("#email").val() == "") {
      $("#alert").html("Enter email");
      $("#alert").css("display", "block");
      conditionform = 0;
    } else if (!boxes) {
      conditionform = 0;
      $("#alert").html("Enter Atleat 1 domain of interest");
      $("#alert").css("display", "block");
    }
    if (conditionform == 1) {
      callajax(1, new FormData(this), 1);
    }
  }
});

function deleterow(x) {
  if (confirm("are yo sure you want to delete?")) {
    let obj = {
      id: x,
      pg: pagenumber,
    };
    callajax(4, obj, pagenumber);
  }
}

function updaterow(x, pgno) {
  $("#insert").attr("id", "update");
  $.ajax({
    url: "update.php",
    type: "POST",
    data: {
      id: x,
    },
    dataType: "JSON",
    success: function (data) {
      $("#idrow").val(x);
      $("#name").val(data.name);
      $("#email").val(data.email);
      data.doi.includes("php") == true
        ? $("#customCheck1").prop("checked", true)
        : $("#customCheck1").prop("checked", false);
      data.doi.includes("java") == true
        ? $("#customCheck2").prop("checked", true)
        : $("#customCheck2").prop("checked", false);
      data.doi.includes("js") == true
        ? $("#customCheck3").prop("checked", true)
        : $("#customCheck3").prop("checked", false);
      $("#submit").html("update");

      $("#update").on("submit", function (e) {
        e.preventDefault();
        callajax(2, new FormData(this), pgno);
      });
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    },
  });
}

function deleteimage(id, imageid) {
  let obj = { id: id, x: imageid, pg: pagenumber };
  if (confirm("are yo sure you want to delete?")) {
    callajax(3, obj, pagenumber);
  }
}

function pagination(pageno) {
  pagenumber = pageno;
  $.ajax({
    url: "table.php",
    type: "post",
    data: {
      val: $("#myInput").val(),
      pagesize: pagesize,
      pg: pageno,
      orderid: orderno,
    },
    success: function (data) {
      $("#main-content").html(data);
      if (orderno == 0 || orderno == 2) {
        $("#downarrowid").css("display", "none");
      } else if (orderno == 1) {
        $("#uparrowid").css("display", "none");
        $("#downarrowid").css("display", "block");
      } else if (orderno == 3) {
        $("#uparrowname").css("display", "none");
        $("#downarrowname").css("display", "block");
      } else if (orderno == 4) {
        $("#uparrowname").css("display", "block");
        $("#downarrowname").css("display", "none");
      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    },
  });
}

function callajax(flag, formdta, pgno) {
  let link = flag == 1 ? "insert.php" : "updatedata.php";
  if (flag == 3) link = "deleteimage.php";
  if (flag == 4) link = "delete.php";
  var condition = flag == 1 || flag == 2;
  let obj;
  if (flag == 1 || flag == 2) {
    obj = {
      url: link,
      type: "POST",
      cache:false,
      contentType: false,
      processData: false,
      data: formdta,
      success: function (data) {
         $("#targetLayer").html(data);
        if (flag == 2) {
          $("#update").attr("id", "insert");
          $("#submit").html("submit");
          pagination(pgno);
        } else {
          loadtable();
          $("#alert").css("display", "none");
        }
        document.getElementById("insert").reset();
        // return false;
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      },
    };
  } else {
    obj = {
      url: link,
      type: "POST",
      data: formdta,
      success: function (data) {
        //$("#targetLayer").html(data);
        pagination(pgno);
        // return false;
      },
      error: function (data) {
        console.log("error");
        console.log(data);
      },
    };
  }
  $.ajax(obj);
}

function sortorder(pageno, x) {
  orderno = x;
  $.ajax({
    url: "table.php",
    type: "post",
    data: {
      pg: pageno,
      orderid: x,
    },
    success: function (data) {
      $("#main-content").html(data); //table
      if (x == 0 || x == 2) {
        $("#downarrowid").css("display", "none");
      } else if (x == 1) {
        $("#uparrowid").css("display", "none");
        $("#downarrowid").css("display", "block");
      } else if (x == 3) {
        $("#uparrowname").css("display", "none");
        $("#downarrowname").css("display", "block");
      } else if (x == 4) {
        $("#uparrowname").css("display", "block");
        $("#downarrowname").css("display", "none");
      }
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    },
  });
}

function changepagesize(x) {
  pagesize = x;
  $.ajax({
    url: "table.php",
    type: "post",
    data: {
      pagesize: x,
    },
    success: function (data) {
      $("#main-content").html(data); //table
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    },
  });
}

// $("#myInput").on("keyup", function () {
//   var value = $(this).val().toLowerCase();
//   $("#myTable tr").filter(function () {
//     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
//   });
// });

function search() {
  $.ajax({
    url: "table.php",
    type: "post",
    data: {
      pg: pagenumber,
      val: $("#myInput").val(),
    },
    success: function (data) {
      $("#main-content").html(data); //table
    },
    error: function (data) {
      console.log("error");
      console.log(data);
    },
  });
}
