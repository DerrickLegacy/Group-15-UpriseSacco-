import java.io.*;
import java.net.*;
import java.util.*;
import java.sql.*;
import java.sql.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;

public class Server {
    public static void main(String[] args) {
        try {
            ServerSocket serverSocket = new ServerSocket(33000);
            System.out.println("Server started and listening on port 3306...");

            while (true) {
                Socket soc = serverSocket.accept();
                System.out.println("Client connected: " + soc.getInetAddress().getHostAddress());

                // Start a new thread to handle each client connection
                ClientHandler clientHandler = new ClientHandler(soc);
                clientHandler.start();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}

class ClientHandler extends Thread {
    private Socket soc;
    private Scanner input;
    private static PrintWriter output;
    private String command;
    private String response;
    // private String response2;

    public static String drivers = "com.mysql.cj.jdbc.Driver";
    private String url = "jdbc:mysql://localhost:3306/uprisesacco";
    private String userName = "root";
    private String passWord = "";
    String password;
    public static String active_user;
    public static String loanApplicationNumber;
    public static int client_id = 0;
    int sacco_contribution_goals = 1200000;
    String client_full_name;
    String loanss;
    String Contrib;

    // Method to manage socket Inputs and Outputs
    public ClientHandler(Socket soc) {
        try {
            this.soc = soc;
            input = new Scanner(soc.getInputStream());
            output = new PrintWriter(soc.getOutputStream(), true);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Method to handle request Commands
    public void run() {
        try {
            while (input.hasNextLine()) {
                command = input.nextLine();
                String[] commandParts = command.split(" ");
                response = "";
                Class.forName(drivers);
                Connection con = DriverManager.getConnection(url, userName, passWord);

                // Handle different commands
                switch (commandParts[0]) {

                    case "login":
                        String username = commandParts[1];
                        String password = commandParts[2];
                        response = memberLogin(username, password);
                        break;
                    case "message":

                        try {
                            String loan_grant = "SELECT * FROM loan WHERE client_id = ? AND grant_status IN ('No Action Yet', 'Granted') AND client_decision = 'No Action'";
                            PreparedStatement grant_status_statement = con.prepareStatement(loan_grant);
                            grant_status_statement.setInt(1, client_id);
                            ResultSet grant_result = grant_status_statement.executeQuery();
                            if (grant_result.next()) {
                                String grant_status = grant_result.getString("grant_status");
                                String client_loan_decision = grant_result.getString("client_decision");

                                if (grant_status.equals("Granted") && client_loan_decision.equals("No Action")) {
                                    response = "Loan has been Granted !";

                                } else {
                                    response = "Loan request has not been Granted yet!";

                                }
                            }
                        } catch (Exception e) {
                            // If no result from database
                        }
                        System.out.println("Notification sent successfully.");

                        break;

                    case "recover":
                        String memberID = commandParts[1];
                        String phoneNumber = commandParts[2];
                        System.out.println(phoneNumber);
                        response = recoveryResponse(memberID, phoneNumber);

                        break;
                    case "deposit":
                        double amount = Double.parseDouble(commandParts[1]);
                        String dateDeposited = commandParts[2];
                        String receiptNumber = commandParts[3];
                        response = handleDeposit(amount, dateDeposited, receiptNumber);
                        break;
                    case "CheckStatement":
                        String dateFrom = commandParts[1];
                        String dateTo = commandParts[2];
                        try {
                            String contri_check = "SELECT receipt_no, client_pledge_cleared AS '(Contribution/120,000) (Shs.)', contribution_progress, deposit_date FROM contributions WHERE client_id = ? AND deposit_date BETWEEN ? AND ? ";
                            PreparedStatement contribution = con.prepareStatement(contri_check);
                            contribution.setInt(1, client_id);
                            contribution.setString(2, dateFrom);
                            contribution.setString(3, dateTo);

                            ResultSet resultSet = contribution.executeQuery();
                            Double average_contribution_performance = 0.0;
                            Double average_loan_performance = 0.0;
                            Double total_rows = 0.0;
                            Double total_contribution = 0.0;
                            Double total_row_count = 0.0;
                            while (resultSet.next()) {
                                int receiptNo = resultSet.getInt("receipt_no");
                                double contributionAmount = resultSet.getDouble("(Contribution/120,000) (Shs.)");
                                int contributionProgress = resultSet.getInt("contribution_progress");
                                String depositDate = resultSet.getString("deposit_date");
                                Contrib = "CONTRIBUTIONS:: Receipt No: {" + receiptNo + "}"
                                        + " Contribution Amount: { Shs."
                                        + contributionAmount + "}" +
                                        " Contribution Progress: {" + contributionProgress + "%}"
                                        + "            Deposit Date: {"
                                        + depositDate + "}";

                                average_contribution_performance = average_contribution_performance
                                        + contributionProgress;
                                total_contribution = total_contribution + contributionAmount;
                                total_rows++;
                            }

                            String Totals = "Total Contribution : {" + total_contribution + "} " + "Out Of"
                                    + " {" + sacco_contribution_goals + "} Average Contribution Progress : {"
                                    + average_contribution_performance + "%}";

                            // Define the date format
                            DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");

                            // Parse the input date strings to Date objects
                            java.util.Date fromDate = dateFormat.parse(dateFrom);
                            java.util.Date toDate = dateFormat.parse(dateTo);

                            // Loan Repayment Performance
                            String loan_check = "SELECT loan_application_no, payment_period, start_date, end_date, clearance_date, clearance_status, loan_request_amount, loan_progress_status, loan_performance FROM loan WHERE client_id = ? AND start_date BETWEEN ? AND ?";
                            PreparedStatement loan_stat = con.prepareStatement(loan_check);
                            loan_stat.setInt(1, client_id);
                            loan_stat.setDate(2, new java.sql.Date(fromDate.getTime())); // Convert Date to
                                                                                         // java.sql.Date
                            loan_stat.setDate(3, new java.sql.Date(toDate.getTime())); // Convert Date to java.sql.Date

                            ResultSet loan_resultSet = loan_stat.executeQuery();

                            while (loan_resultSet.next()) {
                                int loanApplicationNo = loan_resultSet.getInt("loan_application_no");
                                String paymentPeriod = loan_resultSet.getString("payment_period");
                                String startDate = loan_resultSet.getString("start_date");
                                String endDate = loan_resultSet.getString("end_date");
                                String clearanceDate = loan_resultSet.getString("clearance_date");
                                String clearanceStatus = loan_resultSet.getString("clearance_status"); // New field
                                double loanRequestAmount = loan_resultSet.getDouble("loan_request_amount");
                                int loanProgressStatus = loan_resultSet.getInt("loan_progress_status");
                                double loanPerformance = loan_resultSet.getDouble("loan_performance");
                                loanss = "LOAN STATUS:: Loan Application No: {" + loanApplicationNo + "} "
                                        + "Loan Request Amount: {"
                                        + loanRequestAmount + "} "
                                        + "Payment Period: {" + paymentPeriod + "} " + "Start Date: {" + startDate
                                        + "} "
                                        + "End Date: {" + endDate + "} " + "Clearance Date: {" + clearanceDate + "} " +
                                        "Clearance Status: {" + clearanceStatus + "} " + "Loan Progress Status: {"
                                        + loanProgressStatus + "} " + "Loan Performance: {" + loanPerformance + "} ";

                                average_loan_performance = average_loan_performance + loanPerformance;
                                total_row_count++;
                            }

                            String checkstat = Contrib + " *** " + Totals
                                    + "             " + loanss;
                            response = checkstat;
                            // Close the ResultSet and PreparedStatement
                            resultSet.close();
                            contribution.close();

                        } catch (Exception e) {
                            e.printStackTrace();
                        }

                        break;
                    case "requestLoan":
                        double loanAmount = Double.parseDouble(commandParts[1]);
                        int paymentPeriod = Integer.parseInt(commandParts[2]);
                        int applicationNumber = 0;
                        try {
                            String user_id_query = "SELECT clientName, id from members where username = ?";
                            PreparedStatement userIDStatement = con.prepareStatement(user_id_query);
                            userIDStatement.setString(1, active_user);
                            ResultSet resultSet = userIDStatement.executeQuery();

                            if (resultSet.next()) {
                                client_id = resultSet.getInt("id");
                                client_full_name = resultSet.getString("clientName");

                                String user_contrib = "SELECT SUM(client_pledge_cleared) AS total_contribution FROM contributions WHERE client_id = ?";
                                PreparedStatement user_contrib_status = con.prepareStatement(user_contrib);
                                user_contrib_status.setInt(1, client_id);
                                ResultSet contrib_status = user_contrib_status.executeQuery();

                                if (contrib_status.next()) {
                                    System.out.println("Client ID print  " + client_id);

                                    int client_cont_amount = contrib_status.getInt("total_contribution");
                                    System.out.println(client_cont_amount);

                                    if (loanAmount > ((3.0 / 4.0) * client_cont_amount)) {
                                        String resp = "You have requested " + loanAmount
                                                + " which is more than (3/4) of your total contribution of "
                                                + client_cont_amount;
                                        response = resp;
                                    } else {
                                        // registering loan details in the database
                                        try {
                                            // Check if loan exists
                                            String loaned = "SELECT * from loan where client_id = ? and grant_status IN(?,?) and loan_progress_status != 100";
                                            PreparedStatement Statement_query = con.prepareStatement(loaned);
                                            String m1 = "No Action Yet";
                                            String m2 = "Approved";

                                            Statement_query.setInt(1, client_id);
                                            Statement_query.setString(2, m1);
                                            Statement_query.setString(3, m2);

                                            ResultSet resultSets = Statement_query.executeQuery();
                                            if (resultSets.next()) {
                                                int loan_request_amount = resultSets.getInt("loan_request_amount");
                                                applicationNumber = resultSets.getInt("loan_application_no");
                                                String result = "Request Failed! You have unsettled loan balance  "
                                                        + loan_request_amount + " under receipt No. "
                                                        + applicationNumber + "";
                                                response = result;
                                            } else {

                                                applicationNumber = generateRandom8DigitNumber();
                                                System.out.println("App Id 1 :" + applicationNumber);
                                                System.out.println("Loan Amount :" + loanAmount);
                                                System.out.println("Payment Period :" + paymentPeriod);
                                                String loanQuery = "INSERT INTO loan (loan_application_no, client_id, payment_period, loan_request_amount) VALUES (?,?,?,?)";
                                                PreparedStatement loan_info = con.prepareStatement(loanQuery);
                                                loan_info.setInt(1, applicationNumber);
                                                loan_info.setInt(2, client_id);
                                                loan_info.setInt(3, paymentPeriod);
                                                loan_info.setDouble(4, loanAmount);
                                                loan_info.executeUpdate();

                                                // Seeting the mothly payment average plan
                                                String monthly_plan = "UPDATE loan SET monthly_payment_plan = (loan_request_amount/payment_period)";
                                                PreparedStatement plan = con.prepareStatement(monthly_plan);
                                                plan.executeUpdate();

                                                String request_update = "Loan request Of { " + loanAmount
                                                        + " } Submited under receipt No. { " + applicationNumber
                                                        + " } for payment period of { " + paymentPeriod + " }";
                                                response = request_update;
                                            }

                                        } catch (Exception e) {

                                            e.printStackTrace(output);
                                            e.printStackTrace();
                                        }
                                    }

                                }
                            } else {
                                System.out.println("No client found for the given username.");
                            }
                            con.close();
                        } catch (Exception e) {
                            e.printStackTrace(output);
                        }
                        break;

                    case "LoanRequestStatus":
                        loanApplicationNumber = commandParts[1];
                        String grant_status = "Approved";
                        String loan_request_status = "SELECT * from loan where loan_application_no = ? AND grant_status = ? AND client_id = ?";
                        PreparedStatement loan_details = con.prepareStatement(loan_request_status);
                        loan_details.setString(1, loanApplicationNumber);
                        loan_details.setString(2, grant_status);
                        loan_details.setInt(3, client_id);
                        System.out.println(client_id);

                        ResultSet resultSet = loan_details.executeQuery();

                        if (resultSet.next()) {
                            System.out.println("Loan Has been Approved");
                            String grant = resultSet.getString("grant_status");
                            int clearance_status = resultSet.getInt("clearance_status");
                            int monthly_payment_plan = resultSet.getInt("monthly_payment_plan");
                            int loan_request_amount = resultSet.getInt("loan_request_amount");
                            int payment_period = resultSet.getInt("payment_period");

                            System.out.println("Grant Status: " + grant);
                            System.out.println("Clearance Status: " + clearance_status);
                            System.out.println("Monthly Payment Plan: " + monthly_payment_plan);
                            System.out.println("Loan Request Amount: " + loan_request_amount);
                            // System.out.println("Loan Progress Amount: " + loan_progress_amount);
                            System.out.println("Payment Period: " + payment_period);
                            System.out.println("--------------------------------------");
                            response = "Loan Has been Approved";
                        } else {
                            System.out.println("Loan Not Found or Not Approved");
                            response = "Loan  Not Approved";
                        }
                        break;
                    case "exit":
                        response = "exit";
                        break;
                    case "yes":
                        try {
                            // Get the current date as a SQL Date object
                            Date currentDate = new Date(System.currentTimeMillis());
                            String client_decision_yes = "UPDATE loan SET client_decision = 'Accepted', start_date = ? WHERE client_id = ?";
                            PreparedStatement client_decision_statement_yes = con.prepareStatement(client_decision_yes);
                            client_decision_statement_yes.setDate(1, currentDate);
                            client_decision_statement_yes.setInt(2, client_id);
                            client_decision_statement_yes.executeUpdate();
                            response = "Loan has been registerd";
                        } catch (Exception e) {
                            e.printStackTrace(output);
                            response = "Command not valid for this user ! Try out those on list";
                        }
                        break;
                    case "No":
                        try {
                            String client_decision_no = "UPDATE loan SET client_decision = Cancel WHERE client_id = ?";
                            PreparedStatement client_decision_statement_no = con.prepareStatement(client_decision_no);
                            client_decision_statement_no.setInt(1, client_id);
                            client_decision_statement_no.executeUpdate();
                        } catch (Exception e) {
                            response = "Invalid command";
                        }
                        break;
                    default:
                        response = "Invalid command";
                        break;
                }

                output.println(response);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public String memberLogin(String username, String password) {
        try {
            Class.forName(drivers);
            Connection con = DriverManager.getConnection(url, userName, passWord);
            String sql = "SELECT COUNT(*), id  FROM members WHERE username = ? AND password = ?";
            PreparedStatement statement = con.prepareStatement(sql);
            statement.setString(1, username);
            statement.setString(2, password);
            ResultSet resultSet = statement.executeQuery();
            if (resultSet.next()) {
                int count = resultSet.getInt(1);
                client_id = resultSet.getInt("id");
                System.out.println(client_id);
                if (count > 0) {
                    active_user = username;

                    String clearance_date = "UPDATE loan SET clearance_date = DATE_ADD(start_date, INTERVAL payment_period MONTH) WHERE clearance_date IS NULL AND start_date IS NOT NULL";
                    PreparedStatement clearanceDates = con.prepareStatement(clearance_date);
                    clearanceDates.executeUpdate();
                    // Calculating or updating loan_performance for every login
                    String loan_performance = "UPDATE loan SET loan_performance = ((DATEDIFF(clearance_date, end_date) / 31) / payment_period) * 100";
                    PreparedStatement performance = con.prepareStatement(loan_performance);
                    performance.executeUpdate();
                    // Calculating or updating contribution_performance for every login
                    String contribution_performance = "UPDATE contributions SET contribution_progress = ((client_pledge_cleared/?) * 100)";
                    PreparedStatement contri_performance = con.prepareStatement(contribution_performance);
                    contri_performance.setInt(1, sacco_contribution_goals);
                    contri_performance.executeUpdate();

                    return "Login successful!";
                } else {
                    return "Login failed.";
                }
            }
        } catch (Exception e) {
            // e.printStackTrace();
            response = "Database Server Connection Error";
        }
        return "";
    }

    public String recoveryResponse(String memberID, String phoneNumber) throws SQLException {
        try {
            Class.forName(drivers);
            Connection con = DriverManager.getConnection(url, userName, passWord);

            loanApplicationNumber = generateRandomPassword(8);

            String sql = "SELECT COUNT(*) FROM members WHERE id = ? AND phoneNumber = ?";
            PreparedStatement statement = con.prepareStatement(sql);
            statement.setString(1, memberID);
            statement.setString(2, phoneNumber);
            ResultSet resultSet = statement.executeQuery();

            if (resultSet.next()) {
                int count = resultSet.getInt(1);
                if (count > 0) {
                    password = generateRandomPassword(5);
                    String updateSql = "UPDATE members SET password = ? WHERE client_id = ?";
                    PreparedStatement updateStatement = con.prepareStatement(updateSql);
                    updateStatement.setString(1, password);
                    updateStatement.setString(2, memberID);
                    updateStatement.executeUpdate();
                    return "Use this new password to login :" + password;
                } else {

                    String referencenumber = generateReferenceNumber(8);
                    String insertQuery = "INSERT INTO login_reference (client_id, phoneNumber, ref_number) VALUES (?, ?, ?)";
                    PreparedStatement reference = con.prepareStatement(insertQuery);
                    reference.setString(1, memberID);
                    reference.setString(2, password);
                    reference.setString(3, referencenumber);
                    reference.executeUpdate();
                    response = "exit";

                    return "Please return after a day with reference number :" + referencenumber;

                }

            }

        } catch (Exception e) {
            // e.printStackTrace();
            return "Invalid Details. Consult your Administrator";
        }
        return "";
    }

    public String handleDeposit(double Amount, String date, String receiptNumber) {
        try {

            Class.forName(drivers);
            Connection con = DriverManager.getConnection(url, userName, passWord);

            // Check if the receipt number exists in the database
            String checkReceiptQuery = "SELECT COUNT(*) FROM contributions WHERE receipt_no = ? AND deposit_date = ? AND client_pledge_cleared = ?";
            PreparedStatement checkReceiptStatement = con.prepareStatement(checkReceiptQuery);
            checkReceiptStatement.setString(1, receiptNumber);
            checkReceiptStatement.setString(2, date);
            checkReceiptStatement.setDouble(3, Amount);

            ResultSet receiptResult = checkReceiptStatement.executeQuery();
            if (receiptResult.next()) {
                int count = receiptResult.getInt(1);
                if (count > 0) {
                    return "Deposit was made successfully.";
                } else {
                    return "Please check later. New information will be uploaded soon.";
                }
            }
        } catch (Exception e) {
            e.printStackTrace(output);
        }
        return "";
    }

    // method generates random passwords for the users
    private String generateRandomPassword(int length) {
        StringBuilder sb = new StringBuilder();

        for (int i = 0; i < length; i++) {
            char randomChar = getRandomCharacter();
            sb.append(randomChar);
        }

        return sb.toString();
    }

    private char getRandomCharacter() {
        int rand = (int) (Math.random() * 62);

        if (rand <= 9) {
            int ascii = rand + 48;
            return (char) ascii;
        } else if (rand <= 35) {
            int ascii = rand + 55;
            return (char) ascii;
        } else {
            int ascii = rand + 61;
            return (char) ascii;
        }
    }

    // Method generates random numbers that are used as reference by the customers
    public String generateReferenceNumber(int length) {
        StringBuilder sb = new StringBuilder();
        Random random = new Random();

        for (int i = 0; i < length; i++) {
            sb.append(random.nextInt(10)); // Append random digits (0 to 9)
        }

        return sb.toString();
    }

    // Method to generate *-Digit random number for loan application id
    public static int generateRandom8DigitNumber() {
        // Create a Random object
        Random random = new Random();

        // Generate a random integer with 8 digits (between 10000000 and 99999999)
        int min = 10000000;
        int max = 99999999;
        int randomNumber = random.nextInt(max - min + 1) + min;

        return randomNumber;
    }

}
