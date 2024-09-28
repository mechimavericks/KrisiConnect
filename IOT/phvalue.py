def getThePhValue(mv):
    """
    Estimate soil pH based on moisture value using a linear regression model.
    
    Args:
    moisture_value (float): The moisture content of the soil in percentage (0-100%).
    
    Returns:
    float: Estimated pH value.
    """
    # Regression coefficients
    m = -0.025  # Slope calculated from the data
    b = 7.03    # Intercept calculated from the data
    
    # Estimate pH using the linear regression equation
    estimated_ph = m * mv + b
    return estimated_ph


