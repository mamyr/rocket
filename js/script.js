const langID = () => {
    let selectedIndex = document.getElementById("langID").selectedIndex;
    let languagesSelect = document.getElementById("langID");
    console.log(languagesSelect.options[selectedIndex].value);
    console.log(document.location.host);
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

const showRead = (name, title, text) => {
    document.getElementById('name').value = name;
    document.getElementById('title').value = title;
    document.getElementById('text').value = text;
}

const listSortName = (e) => {
    let selectedIndex = document.getElementById("langID").selectedIndex;
    let languagesSelect = document.getElementById("langID");
    console.log(languagesSelect.options[selectedIndex].value);
    console.log(document.location.host);
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
    console.log(document.location.host);
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