<%@ include file="/common/include/top_level_page.jsp"%>
<%@ include file="/common/include/end_user.jsp"%>

<%--
String message = "Your session has timed out.  Please log back in.";
--%>

<%@ page import="moai.liveexchange.api.*,
                 moai.liveexchange.common.*" %>

<%

// Session retrieval
//APISession apiSession = APISessionFactory.getAPISession(request);
//out.println("Session: " + request.getParameter("LiveExchangeSession") + "<BR>");
//out.println("User: " + securityBean.getUserName());

String message = null;

/* // find out original user's OID
if (securityBean.isGuestUser()) {
  message = "Your guest account has been re-authenticated";
}
else {
*/
  if (securityBean.loggedIn()) {
        message = "You have been re-authenticated";
  }
  else {
        message = "Your session has timed out.  Please log back in or use the guest account.";
  }
/*
}
*/

%>


<HTML>

<head>
  <title>BugsEye Error</title>
  <jsp:include page="/common/style/style_link.jsp"/>
</head>

<body bgcolor="#FFFFFF" link="#006699" vlink="#003366" alink="#FF9900">
<table border="0" width="800" cellspacing="0" cellpadding="0">
  <tr>
    <td width="649">
    <img name="toppng2_r1_c01" src="/images/NavBarTitleLeft.gif" width="649" height="112" border="0">
    </td>
    
    <td width="50%" valign="top">
    <div align="left">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><img name="toppng2_r1_c10" src="/images/NavBarTitleAd_Top.gif"
        width="151" height="21" border="0"></td>
      </tr>
      <tr>
        <td width="100%">
          <img src="/images/NavBarTitleAd_Left.gif" width="42" height="91" border="0"><IMG SRC="/images/spacer.gif"
           height=91 width=73 border=0 hspace="0" vspace="0"><img src="/images/NavBarTitleAd_Right.gif" width="36" height="91" border="0">
        </td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
</table>

<%-- Include Navigation Bar --%>

<table width="800" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr> 
    <td nowrap width="528" valign="middle" class="btopnav">
      &nbsp;       <a href="/EndUser/index.msp?LiveExchangeSession=<%= session.getId()%>">HOME</a>
        &nbsp;|&nbsp;<a href="/EndUser/login/login.msp?LiveExchangeSession=<%= session.getId()%>">LOGIN</a>
        &nbsp;|&nbsp;<a href="/EndUser/register/registrationLocale.msp?LiveExchangeSession=<%= session.getId()%>">REGISTER</a>
    </td>
  </tr>
</table>


<BR><BR>
<span class="bsmall">
<%= message %>
</span>

<%-- Include login form if timed out? --%>





<!---- This is the default spacing between the footer and the contents of a page. ---->
<img src="/images/spacer.gif" height=20 width="100%">

<!---- Show the Moai footer and logo. ---->
<table border=0 cellpadding=0 cellspacing=0>
<tr>
<td><img src="/images/NavBarTitle_Underline.gif" height="1" border="0"></td>
</tr>
<tr>
<td width="100%" valign="top" align="left">
    <a href="http://www.moai.com"><img src="/images/b2b_moai_footer_logo.gif"
     width=240 height=44 alt="Moai's Website" border="0"></a>
  </td>
</tr>
</table>
<!-- MAINBOTTOMTABLE:END:512 -->


</BODY>
</HTML>




