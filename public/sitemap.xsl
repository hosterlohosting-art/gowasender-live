<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>XML Sitemap - WA Sender</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style type="text/css">
					body {
						font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
						color: #333;
						margin: 0;
						padding: 40px;
						background: #f8f9fe;
					}
					.container {
						max-width: 1000px;
						margin: 0 auto;
						background: #fff;
						padding: 40px;
						border-radius: 20px;
						box-shadow: 0 10px 30px rgba(0,0,0,0.05);
					}
					h1 {
						color: #128C7E;
						font-size: 28px;
						margin-bottom: 10px;
					}
					p {
						font-size: 14px;
						color: #666;
						margin-bottom: 30px;
					}
					table {
						width: 100%;
						border-collapse: collapse;
						margin-top: 20px;
					}
					th {
						text-align: left;
						padding: 15px;
						background: #f1f3f5;
						font-size: 13px;
						font-weight: 700;
						color: #4a5073;
						text-transform: uppercase;
						letter-spacing: 0.5px;
					}
					td {
						padding: 15px;
						border-bottom: 1px solid #edf2f7;
						font-size: 14px;
						word-break: break-all;
					}
					tr:hover td {
						background: #fdfdfd;
					}
					a {
						color: #128C7E;
						text-decoration: none;
						font-weight: 500;
					}
					a:hover {
						text-decoration: underline;
					}
					.priority {
						display: inline-block;
						padding: 4px 10px;
						background: #e3fcf0;
						color: #0d885a;
						border-radius: 6px;
						font-weight: 700;
						font-size: 12px;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<h1>XML Sitemap</h1>
					<p>This is a human-readable XML Sitemap for search engines like Google, Bing, and Yandex.</p>
					<table>
						<thead>
							<tr>
								<th>URL</th>
								<th>Priority</th>
								<th>Last Modified</th>
							</tr>
						</thead>
						<tbody>
							<xsl:for-each select="sitemap:urlset/sitemap:url">
								<tr>
									<td>
										<a href="{sitemap:loc}">
											<xsl:value-of select="sitemap:loc"/>
										</a>
									</td>
									<td>
										<span class="priority">
											<xsl:value-of select="concat(sitemap:priority*100, '%')"/>
										</span>
									</td>
									<td>
										<xsl:value-of select="sitemap:lastmod"/>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
