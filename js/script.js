const langID = () => {
    let selectedIndex = document.getElementById("langID").selectedIndex;
    let languagesSelect = document.getElementById("langID");
    console.log(languagesSelect.options[selectedIndex].value);
    let lang = languagesSelect.options[selectedIndex].value;
    if(lang != "Выбор языка")
        document.location.href = document.location.pathname+'?langID='+lang;
}

const showDiv = () => {
    document.getElementById('createBook').style.display = "none";
    document.getElementById('loadingGif').style.display = "block";
    setTimeout(function() {
      document.getElementById('loadingGif').style.display = "none";
      document.getElementById('showme').style.display = "block";
    },10000);
     
  }

const showRead = (id, name, title, text, image) => {
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('title').value = title;
    document.getElementById('text').value = text;
    document.getElementById('image').src = image;
}

const listSortName = (e) => {
    let selectedIndex = document.getElementById("langID").selectedIndex;
    let languagesSelect = document.getElementById("langID");
    console.log(languagesSelect.options[selectedIndex].value);
    let lang = languagesSelect.options[selectedIndex].value;

    if (document.getElementById(e).className === "mobile-arrow down"){
        document.getElementById(e).className = "mobile-arrow up"
        if(lang != "Выбор языка")
            document.location.href = document.location.pathname+'?langID='+lang+'&sort=name&order=asc';
        else
            document.location.href = document.location.pathname+'?sort=name&order=asc';
    } else {
        document.getElementById(e).className = "mobile-arrow down"
        if(lang != "Выбор языка")
            document.location.href = document.location.pathname+'?langID='+lang+'&sort=name&order=desc';
        else
            document.location.href = document.location.pathname+'?sort=name&order=desc';
    }
}

const listSortDate = (e) => {
    let selectedIndex = document.getElementById("langID").selectedIndex;
    let languagesSelect = document.getElementById("langID");
    console.log(languagesSelect.options[selectedIndex].value);
    let lang = languagesSelect.options[selectedIndex].value;

    if (document.getElementById(e).className === "mobile-arrow down"){
        document.getElementById(e).className = "mobile-arrow up"
        if(lang != "Выбор языка")
            document.location.href = document.location.pathname+'?langID='+lang+'&sort=date&order=asc';
        else
            document.location.href = document.location.pathname+'?sort=date&order=asc';
    } else {
        document.getElementById(e).className = "mobile-arrow down"
        if(lang != "Выбор языка")
            document.location.href = document.location.pathname+'?langID='+lang+'&sort=date&order=desc';
        else
            document.location.href = document.location.pathname+'?sort=date&order=desc';
    }
}

const showImg = () => {
    let file = document.getElementById("avatar").files[0];
    let img = document.getElementById("imageBook");
    img.setAttribute("src",URL.createObjectURL(file));
    const reader = new FileReader();

    var base64data = "";
    reader.readAsDataURL(file); 
    reader.onloadend = function() {
        base64data = reader.result;                
        document.getElementById("fileblob").value = base64data;
    }
}