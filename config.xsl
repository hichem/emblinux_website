<?xml version='1.0'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="no" />
<xsl:template match="/*">
<table cellspacing="1" cellpadding="2" bgcolor="#7777FF" border="1">
	<xsl:for-each select="*">
	<tr>
		<td><xsl:value-of select= "@name"/></td>
		<td>
				<xsl:for-each select="*">
				<table>
          <tr>
            <td width="200"><xsl:value-of select="@name"/></td>
            <td><xsl:value-of select="."/></td>
          </tr>
				</table>
				</xsl:for-each>
		</td>
	</tr>
	</xsl:for-each>
</table>
</xsl:template>
</xsl:stylesheet>
