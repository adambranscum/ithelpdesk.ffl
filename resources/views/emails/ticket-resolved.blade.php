<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Resolved</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .success-badge {
            display: inline-block;
            background-color: #d4edda;
            color: #155724;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 2px solid #c3e6cb;
        }
        .ticket-info {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .ticket-info h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 140px;
        }
        .info-value {
            color: #2c3e50;
            flex: 1;
        }
        .message-box {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .message-box h4 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .message-content {
            color: #495057;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            opacity: 0.9;
        }
        .feedback-section {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .feedback-section h4 {
            margin: 0 0 10px 0;
            color: #004085;
        }
        .feedback-section p {
            margin: 0;
            color: #004085;
            font-size: 14px;
        }
        .footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #bdc3c7;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">
                <img width="100" height="100" src="https://ithelpdesk.nlrlibrary.org/images/logo.png">
            </div>
            <h1 style="color:black;">Ticket Resolved</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <span class="success-badge">Status Updated: Resolved</span>
            
            <p style="font-size: 16px; color: #2c3e50; margin: 20px 0;">
                Hello <strong>{{ $ticket->from_name }}</strong>,
            </p>

            <p style="font-size: 16px; color: #495057; line-height: 1.6;">
                Great news! Your IT support ticket has been resolved. Our team has completed work on your request and the issue should now be fixed.
            </p>

            <!-- Ticket Information -->
            <div class="ticket-info">
                <h3>Ticket Details</h3>
                <div class="info-row">
                    <div class="info-label">Ticket Number:</div>
                    <div class="info-value"><strong>{{ $ticket->ticket_number }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value">{{ $ticket->subject }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Assigned To:</div>
                    <div class="info-value">{{ $ticket->assigned_to }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submitted:</div>
                    <div class="info-value">{{ $ticket->received_time->format('F d, Y \a\t g:i A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Resolved:</div>
                    <div class="info-value">{{ $ticket->end_time ? $ticket->end_time->format('F d, Y \a\t g:i A') : now()->format('F d, Y \a\t g:i A') }}</div>
                </div>
            </div>
            
        <!-- Footer -->
        <div class="footer">
            <p style="font-weight: 600; font-size: 16px; color: #ffffff; margin-bottom: 10px;">
               NLRPLS IT Support Ticketing System
            </p>
            <p>North Little Rock Library System</p>
            <p>
                Need help? Contact us at 
                <a href="mailto:ithelpdesk@nlrlibrary.org">ithelpdesk@nlrlibrary.org</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} IT Support. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>