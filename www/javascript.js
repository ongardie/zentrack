
function mOvr(src,clrOver,txtOver) {
    src.style.cursor = 'hand'; 
    src.bgColor = clrOver;
    if( txtOver != "" )
       src.children.tags('A')[0].style.color = txtOver;
}
function mOut(src,clrIn,txtIn) {
    src.style.cursor = 'default'; 
    src.bgColor = clrIn; 
    if( txtIn != "" )
       src.children.tags('A')[0].style.color = txtIn;
}
function mClk(src) {
    src.children.tags('A')[0].click();
}
